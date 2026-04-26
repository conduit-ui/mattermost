<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\SlashCommands;

/**
 * Fluent builder for a slash command response payload.
 *
 * Mattermost expects a JSON response with `response_type`, `text`, and optional
 * attachments. This builder produces that payload.
 *
 * @see https://developers.mattermost.com/integrate/slash-commands/#response-parameters
 */
class SlashCommandResponse
{
    private string $responseType = 'ephemeral';

    private ?string $text = null;

    /** @var list<array<string, mixed>> */
    private array $attachments = [];

    public static function make(?string $text = null): self
    {
        $instance = new self;

        if ($text !== null) {
            $instance->text = $text;
        }

        return $instance;
    }

    /**
     * The response is visible to everyone in the channel.
     */
    public function inChannel(): self
    {
        $this->responseType = 'in_channel';

        return $this;
    }

    /**
     * The response is visible only to the user who invoked the command (default).
     */
    public function ephemeral(): self
    {
        $this->responseType = 'ephemeral';

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $attachment
     */
    public function attachment(array $attachment): self
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [
            'response_type' => $this->responseType,
            'text' => $this->text ?? '',
        ];

        if ($this->attachments !== []) {
            $payload['attachments'] = $this->attachments;
        }

        return $payload;
    }
}
