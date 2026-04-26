<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot;

use Closure;
use ConduitUI\Mattermost\Bot\Attributes\Middleware as MiddlewareAttribute;
use ConduitUI\Mattermost\Bot\Middleware\Middleware;
use ConduitUI\Mattermost\WebSocket\Client as WebSocketClient;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher as EventDispatcher;
use Illuminate\Contracts\Queue\ShouldQueue;
use ReflectionClass;
use Throwable;

/**
 * The bot Router.
 *
 * Maps Mattermost WebSocket events to handler classes through a global +
 * per-handler middleware pipeline. Handlers are resolved from the container
 * (so constructor DI works), and Mattermost events are also dispatched as
 * Laravel events so callers can use `Event::listen(...)` independently.
 *
 *   $router->on(PostCreated::class, HandleNewPost::class);
 *   $router->on('*', LogAllEvents::class);            // wildcard
 *
 * To stream WS events through the router automatically, call
 * {@see attachToWebSocketClient()} once during boot.
 *
 * Handlers implementing {@see ShouldQueue} are dispatched onto Laravel's
 * queue rather than running synchronously.
 */
class Router
{
    /** @var array<string, array<int, class-string<Handler>>> */
    private array $handlers = [];

    /** @var array<int, class-string<Middleware>> */
    private array $globalMiddleware = [];

    public function __construct(
        private readonly Container $container,
    ) {}

    /**
     * Register a handler for an event class (or `'*'` for every event).
     *
     * Multiple handlers may be registered against the same key; they run
     * in registration order.
     *
     * @param  class-string<Event>|string  $eventClassOrWildcard
     * @param  class-string<Handler>  $handler
     */
    public function on(string $eventClassOrWildcard, string $handler): self
    {
        $this->handlers[$eventClassOrWildcard][] = $handler;

        return $this;
    }

    /**
     * Append global middleware applied to every handler invocation.
     *
     * @param  class-string<Middleware>  ...$middleware
     */
    public function middleware(string ...$middleware): self
    {
        foreach ($middleware as $class) {
            $this->globalMiddleware[] = $class;
        }

        return $this;
    }

    /**
     * Replace the global middleware list — convenient for service-provider
     * boot when reading the array form from config.
     *
     * @param  array<int, class-string<Middleware>>  $middleware
     */
    public function setGlobalMiddleware(array $middleware): self
    {
        $this->globalMiddleware = array_values($middleware);

        return $this;
    }

    /** @return array<int, class-string<Middleware>> */
    public function globalMiddleware(): array
    {
        return $this->globalMiddleware;
    }

    /**
     * @return array<string, array<int, class-string<Handler>>>
     */
    public function handlers(): array
    {
        return $this->handlers;
    }

    /**
     * Subscribe to all WebSocket events from `$client` and route each one
     * through the bot pipeline. Call once during boot.
     */
    public function attachToWebSocketClient(WebSocketClient $client): void
    {
        $client->onAny(function (Event $event): void {
            $this->dispatch($event);
        });
    }

    /**
     * Run an event through the bot pipeline. Always fires the corresponding
     * Laravel event first, then resolves matching handlers, then runs each
     * one through global + per-handler middleware.
     */
    public function dispatch(Event $event): void
    {
        try {
            /** @var EventDispatcher $events */
            $events = $this->container->make(EventDispatcher::class);
            $events->dispatch($event);
        } catch (Throwable) {
            // Listener failures must not block bot handlers.
        }

        foreach ($this->resolveMatchedHandlers($event) as $handlerClass) {
            $this->runHandler($handlerClass, $event);
        }
    }

    /**
     * @return array<int, class-string<Handler>>
     */
    private function resolveMatchedHandlers(Event $event): array
    {
        $matched = [];

        // Direct class match.
        foreach ($this->handlers[$event::class] ?? [] as $handler) {
            $matched[] = $handler;
        }

        // Mattermost event-name match (e.g. `posted`) so users can register
        // by the underlying string when no typed subclass exists.
        foreach ($this->handlers[$event->name()] ?? [] as $handler) {
            $matched[] = $handler;
        }

        // Wildcard.
        foreach ($this->handlers['*'] ?? [] as $handler) {
            $matched[] = $handler;
        }

        return $matched;
    }

    /**
     * @param  class-string<Handler>  $handlerClass
     */
    private function runHandler(string $handlerClass, Event $event): void
    {
        $pipeline = $this->buildPipeline($handlerClass);

        $pipeline($event);
    }

    /**
     * @param  class-string<Handler>  $handlerClass
     * @return Closure(Event): void
     */
    private function buildPipeline(string $handlerClass): Closure
    {
        $perHandler = $this->resolvePerHandlerMiddleware($handlerClass);
        $stack = [...$this->globalMiddleware, ...$perHandler];

        // Innermost step: actually invoke the handler.
        $next = function (Event $event) use ($handlerClass): void {
            $this->invoke($handlerClass, $event);
        };

        // Build the chain in reverse so the first middleware runs first.
        foreach (array_reverse($stack) as $middlewareClass) {
            $previous = $next;
            $next = function (Event $event) use ($middlewareClass, $previous): void {
                /** @var Middleware $instance */
                $instance = $this->container->make($middlewareClass);

                $instance->handle($event, $previous);
            };
        }

        return $next;
    }

    /**
     * @param  class-string<Handler>  $handlerClass
     * @return array<int, class-string<Middleware>>
     */
    private function resolvePerHandlerMiddleware(string $handlerClass): array
    {
        if (! class_exists($handlerClass)) {
            return [];
        }

        $reflection = new ReflectionClass($handlerClass);
        $middleware = [];

        foreach ($reflection->getAttributes(MiddlewareAttribute::class) as $attribute) {
            $instance = $attribute->newInstance();

            foreach ($instance->middleware as $class) {
                $middleware[] = $class;
            }
        }

        return $middleware;
    }

    /**
     * @param  class-string<Handler>  $handlerClass
     */
    private function invoke(string $handlerClass, Event $event): void
    {
        $handler = $this->container->make($handlerClass);

        if ($handler instanceof ShouldQueue) {
            /** @var BusDispatcher $bus */
            $bus = $this->container->make(BusDispatcher::class);

            $bus->dispatch(new HandleEventJob($handlerClass, $event));

            return;
        }

        if (! $handler instanceof Handler) {
            return;
        }

        $handler->handle($event);
    }
}
