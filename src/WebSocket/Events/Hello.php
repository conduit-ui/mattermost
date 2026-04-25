<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Sent by the server immediately after a successful auth handshake (`hello`).
 *
 * Contains the server version, build date, and build hash. Useful as a
 * cue that the connection is healthy and authenticated.
 */
final class Hello extends Event
{
    public const string EVENT_NAME = 'hello';

    #[\Override]
    public function name(): string
    {
        return self::EVENT_NAME;
    }

    public function serverVersion(): string
    {
        return (string) ($this->data['server_version'] ?? '');
    }
}
