<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fired when a new post is created in any channel the bot can see.
 *
 * Mattermost JSON-encodes the nested `post` object inside `data.post`,
 * so we eagerly decode it here for callers.
 */
final class PostCreated extends Event
{
    public const string EVENT_NAME = 'posted';

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
        return $this->decodeJsonField('post');
    }

    public function channelId(): string
    {
        $post = $this->post();

        return (string) ($post['channel_id'] ?? $this->broadcast['channel_id'] ?? '');
    }

    public function channelType(): string
    {
        return (string) ($this->data['channel_type'] ?? '');
    }

    public function channelName(): string
    {
        return (string) ($this->data['channel_name'] ?? '');
    }

    public function senderName(): string
    {
        return (string) ($this->data['sender_name'] ?? '');
    }

    public function userId(): string
    {
        return (string) ($this->post()['user_id'] ?? '');
    }

    public function message(): string
    {
        return (string) ($this->post()['message'] ?? '');
    }

    public function rootId(): string
    {
        return (string) ($this->post()['root_id'] ?? '');
    }

    /**
     * @return array<string, mixed>|null
     */
    private function decodeJsonField(string $key): ?array
    {
        $raw = $this->data[$key] ?? null;

        if (is_array($raw)) {
            return $raw;
        }

        if (is_string($raw) && $raw !== '') {
            $decoded = json_decode($raw, true);

            return is_array($decoded) ? $decoded : null;
        }

        return null;
    }
}
