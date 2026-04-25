<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost;

use ConduitUI\Mattermost\Bot\Handler;
use ConduitUI\Mattermost\Bot\Middleware\Middleware as BotMiddleware;
use ConduitUI\Mattermost\Bot\Router as BotRouter;
use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use Illuminate\Contracts\Container\Container;
use InvalidArgumentException;

class MattermostManager
{
    /** @var array<string, Mattermost> */
    private array $connections = [];

    public function __construct(
        protected ?Container $container = null,
    ) {}

    public function connection(?string $name = null): Mattermost
    {
        $name ??= config('mattermost.default', 'default');

        if (isset($this->connections[$name])) {
            return $this->connections[$name];
        }

        $config = config("mattermost.connections.{$name}");

        if (! $config) {
            throw new InvalidArgumentException("Mattermost connection [{$name}] is not configured.");
        }

        return $this->connections[$name] = new Mattermost(
            baseUrl: $config['url'],
            token: $config['token'],
        );
    }

    public function purge(?string $name = null): void
    {
        $name ??= config('mattermost.default', 'default');
        unset($this->connections[$name]);
    }

    /**
     * Resolve the bot router from the container.
     */
    public function router(): BotRouter
    {
        return $this->resolveContainer()->make(BotRouter::class);
    }

    /**
     * Register a handler for an event class — proxy to the bot router.
     *
     * @param  class-string<Event>|string  $eventClassOrWildcard
     * @param  class-string<Handler>  $handler
     */
    public function on(string $eventClassOrWildcard, string $handler): BotRouter
    {
        return $this->router()->on($eventClassOrWildcard, $handler);
    }

    /**
     * Append global router middleware.
     *
     * @param  class-string<BotMiddleware>  ...$middleware
     */
    public function middleware(string ...$middleware): BotRouter
    {
        return $this->router()->middleware(...$middleware);
    }

    private function resolveContainer(): Container
    {
        if ($this->container instanceof Container) {
            return $this->container;
        }

        /** @var Container $app */
        $app = app();

        return $app;
    }
}
