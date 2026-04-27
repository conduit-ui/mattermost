<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Interactive;

/**
 * Fluent builder for an interactive action response payload.
 *
 * Mattermost expects a JSON response from the integration URL. The response
 * can update the original post, send an ephemeral message, or do nothing.
 *
 * @see https://developers.mattermost.com/integrate/plugins/interactive-messages/
 */
class InteractiveActionResponse
{
    private ?string $updateText = null;

    /** @var array<string, mixed>|null */
    private ?array $updateProps = null;

    private ?string $ephemeralText = null;

    public static function make(): self
    {
        return new self;
    }

    /**
     * Update the original post's message text.
     */
    public function update(string $text): self
    {
        $this->updateText = $text;

        return $this;
    }

    /**
     * Replace the original post's props (attachments, etc.).
     *
     * @param  array<string, mixed>  $props
     */
    public function props(array $props): self
    {
        $this->updateProps = $props;

        return $this;
    }

    /**
     * Send an ephemeral message visible only to the acting user.
     */
    public function ephemeral(string $text): self
    {
        $this->ephemeralText = $text;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if ($this->updateText !== null) {
            $payload['update'] = ['message' => $this->updateText];

            if ($this->updateProps !== null) {
                $payload['update']['props'] = $this->updateProps;
            }
        } elseif ($this->updateProps !== null) {
            $payload['update'] = ['props' => $this->updateProps];
        }

        if ($this->ephemeralText !== null) {
            $payload['ephemeral_text'] = $this->ephemeralText;
        }

        return $payload;
    }
}
