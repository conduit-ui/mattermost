<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost;

use ConduitUI\Mattermost\Client\Mattermost;
use InvalidArgumentException;

class MattermostManager
{
    /** @var array<string, Mattermost> */
    private array $connections = [];

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
}
