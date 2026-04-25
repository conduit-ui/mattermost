<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fired when a post is deleted (`post_deleted`).
 */
final class PostDeleted extends Event
{
    public const string EVENT_NAME = 'post_deleted';

    #[\Override]
    public function name(): string
    {
        return self::EVENT_NAME;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function post(): ?array
    {
        $raw = $this->data['post'] ?? null;

        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : null;
        }

        return null;
    }

    public function postId(): string
    {
        return (string) ($this->post()['id'] ?? '');
    }

    public function channelId(): string
    {
        return (string) ($this->post()['channel_id'] ?? $this->broadcast['channel_id'] ?? '');
    }

    public function userId(): string
    {
        return (string) ($this->post()['user_id'] ?? '');
    }
}
