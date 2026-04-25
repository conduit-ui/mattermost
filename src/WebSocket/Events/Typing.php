<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fired while a user is typing in a channel (`typing`).
 */
final class Typing extends Event
{
    public const string EVENT_NAME = 'typing';

    #[\Override]
    public function name(): string
    {
        return self::EVENT_NAME;
    }

    public function userId(): string
    {
        return (string) ($this->data['user_id'] ?? '');
    }

    public function channelId(): string
    {
        return (string) ($this->broadcast['channel_id'] ?? '');
    }

    public function parentId(): string
    {
        return (string) ($this->data['parent_id'] ?? '');
    }
}
