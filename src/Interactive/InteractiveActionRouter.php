<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Interactive;

use Closure;
use Illuminate\Contracts\Container\Container;

/**
 * Route-style registration and dispatch for Mattermost interactive actions.
 *
 * Register handlers using `register()` with either a handler class or a closure:
 *
 *   $router->register('approve', ApproveHandler::class);
 *   $router->register('deny', fn (InteractiveAction $a) => InteractiveActionResponse::make()->ephemeral('Denied'));
 *
 * The router resolves class-based handlers from the container so DI works.
 */
class InteractiveActionRouter
{
    /** @var array<string, class-string<InteractiveActionHandler>|Closure(InteractiveAction): InteractiveActionResponse> */
    private array $handlers = [];

    public function __construct(
        private readonly Container $container,
    ) {}

    /**
     * Register a handler for an interactive action ID.
     *
     * @param  class-string<InteractiveActionHandler>|Closure(InteractiveAction): InteractiveActionResponse  $handler
     */
    public function register(string $actionId, string|Closure $handler): self
    {
        $this->handlers[$actionId] = $handler;

        return $this;
    }

    /**
     * Dispatch an incoming interactive action payload to its registered handler.
     *
     * Returns null if no handler matches the action ID.
     */
    public function dispatch(InteractiveAction $action): ?InteractiveActionResponse
    {
        $actionId = $action->actionId();

        $handler = $this->handlers[$actionId] ?? null;

        if ($handler === null) {
            return null;
        }

        if ($handler instanceof Closure) {
            return $handler($action);
        }

        /** @var InteractiveActionHandler $instance */
        $instance = $this->container->make($handler);

        return $instance->handle($action);
    }

    /**
     * Check whether a handler is registered for a given action ID.
     */
    public function hasHandler(string $actionId): bool
    {
        return isset($this->handlers[$actionId]);
    }

    /**
     * @return array<string, class-string<InteractiveActionHandler>|Closure(InteractiveAction): InteractiveActionResponse>
     */
    public function handlers(): array
    {
        return $this->handlers;
    }
}
