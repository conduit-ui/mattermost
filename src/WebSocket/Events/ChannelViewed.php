<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fired when a channel is marked as viewed (`channel_viewed`).
 */
final class ChannelViewed extends Event
{
    public const string EVENT_NAME = 'channel_viewed';

    #[\Override]
    public function name(): string
    {
        return self::EVENT_NAME;
    }

    public function channelId(): string
    {
        return (string) ($this->data['channel_id'] ?? $this->broadcast['channel_id'] ?? '');
    }

    public function userId(): string
    {
        return (string) ($this->broadcast['user_id'] ?? '');
    }
}
