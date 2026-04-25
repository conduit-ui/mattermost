<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Notifications;

/**
 * Fluent payload returned from a notification's `toMattermost()` method.
 *
 * Channels and connections may be set on the message itself (taking precedence
 * over routing on the notifiable) or provided via `routeNotificationFor('mattermost')`.
 */
class MattermostMessage
{
    public ?string $text = null;

    public ?string $channelId = null;

    public ?string $rootId = null;

    public ?string $connection = null;

    /** @var array<int, string>|null */
    public ?array $fileIds = null;

    /** @var array<string, mixed>|null */
    public ?array $props = null;

    public static function create(?string $text = null): self
    {
        $message = new self;
        $message->text = $text;

        return $message;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function channel(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function rootId(string $rootId): self
    {
        $this->rootId = $rootId;

        return $this;
    }

    public function connection(string $connection): self
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * @param  array<int, string>  $fileIds
     */
    public function fileIds(array $fileIds): self
    {
        $this->fileIds = $fileIds;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $props
     */
    public function props(array $props): self
    {
        $this->props = $props;

        return $this;
    }

    /**
     * Attach Slack-style attachments via the `props.attachments` field.
     *
     * @param  array<int, array<string, mixed>>  $attachments
     */
    public function attachments(array $attachments): self
    {
        $props = $this->props ?? [];
        $props['attachments'] = $attachments;
        $this->props = $props;

        return $this;
    }
}
