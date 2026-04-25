<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fired when a user's online status changes (`status_change`).
 */
final class UserStatusChanged extends Event
{
    public const string EVENT_NAME = 'status_change';

    #[\Override]
    public function name(): string
    {
        return self::EVENT_NAME;
    }

    public function userId(): string
    {
        return (string) ($this->data['user_id'] ?? $this->broadcast['user_id'] ?? '');
    }

    public function status(): string
    {
        return (string) ($this->data['status'] ?? '');
    }
}
