<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fired when a user removes a reaction (`reaction_removed`).
 */
final class ReactionRemoved extends Event
{
    public const string EVENT_NAME = 'reaction_removed';

    #[\Override]
    public function name(): string
    {
        return self::EVENT_NAME;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function reaction(): ?array
    {
        $raw = $this->data['reaction'] ?? null;

        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : null;
        }

        return null;
    }

    public function emoji(): string
    {
        return (string) ($this->reaction()['emoji_name'] ?? '');
    }

    public function postId(): string
    {
        return (string) ($this->reaction()['post_id'] ?? '');
    }

    public function userId(): string
    {
        return (string) ($this->reaction()['user_id'] ?? '');
    }

    public function channelId(): string
    {
        return (string) ($this->broadcast['channel_id'] ?? '');
    }
}
