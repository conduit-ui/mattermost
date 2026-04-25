<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Messages;

use Closure;

/**
 * Fluent builder for a Mattermost post payload.
 *
 * Pure value object — produces an array suitable for the Posts API. It does
 * not perform any HTTP calls. Send via the Saloon client / facade.
 *
 * @see https://api.mattermost.com/#tag/posts/operation/CreatePost
 */
class Message
{
    private ?string $channelId = null;

    private ?string $message = null;

    private ?string $rootId = null;

    /** @var list<string> */
    private array $fileIds = [];

    /** @var list<Attachment> */
    private array $attachments = [];

    /** @var array<string, mixed> */
    private array $props = [];

    public static function make(?string $message = null): self
    {
        $instance = new self;

        if ($message !== null) {
            $instance->text($message);
        }

        return $instance;
    }

    /**
     * Target a channel by ID. The Posts API accepts a channel_id, so this
     * method names the channel/channel-id field — callers may pass either a
     * channel ID or a name and resolve it before sending.
     */
    public static function to(string $channel): self
    {
        return (new self)->channel($channel);
    }

    public function channel(string $channelId): self
    {
        $this->channelId = $channelId;

        return $this;
    }

    public function text(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Append additional text to the message body.
     */
    public function append(string $text, string $separator = "\n"): self
    {
        $this->message = $this->message === null
            ? $text
            : $this->message.$separator.$text;

        return $this;
    }

    public function inThread(string $rootId): self
    {
        $this->rootId = $rootId;

        return $this;
    }

    /**
     * @param  list<string>|string  $ids
     */
    public function files(array|string $ids): self
    {
        $ids = is_array($ids) ? $ids : [$ids];

        foreach ($ids as $id) {
            $this->fileIds[] = $id;
        }

        return $this;
    }

    /**
     * Add an attachment via a builder closure or an existing Attachment.
     *
     * @param  Closure(Attachment): void|Closure(Attachment): Attachment|Attachment  $attachment
     */
    public function attachment(Closure|Attachment $attachment): self
    {
        if ($attachment instanceof Attachment) {
            $this->attachments[] = $attachment;

            return $this;
        }

        $built = new Attachment;
        $attachment($built);
        $this->attachments[] = $built;

        return $this;
    }

    /**
     * Set an arbitrary key on the message props bag. Reserved key
     * "attachments" is rejected — use attachment() instead.
     */
    public function prop(string $key, mixed $value): self
    {
        if ($key === 'attachments') {
            throw new \InvalidArgumentException('Use attachment() to set message attachments.');
        }

        $this->props[$key] = $value;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if ($this->channelId !== null) {
            $payload['channel_id'] = $this->channelId;
        }

        $payload['message'] = $this->message ?? '';

        if ($this->rootId !== null) {
            $payload['root_id'] = $this->rootId;
        }

        if ($this->fileIds !== []) {
            $payload['file_ids'] = $this->fileIds;
        }

        $props = $this->props;

        if ($this->attachments !== []) {
            $props['attachments'] = array_map(
                static fn (Attachment $a): array => $a->toArray(),
                $this->attachments,
            );
        }

        if ($props !== []) {
            $payload['props'] = $props;
        }

        return $payload;
    }
}
