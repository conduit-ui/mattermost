<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\SlashCommands;

/**
 * Value object representing an incoming Mattermost slash command webhook payload.
 *
 * Mattermost POSTs a form-encoded payload when a user invokes a custom slash
 * command. This DTO wraps that payload and provides typed convenience accessors
 * including argument parsing helpers.
 */
class SlashCommand
{
    /** @var list<string> */
    private array $parsedArgs;

    /**
     * @param  array<string, mixed>  $payload  The raw webhook payload.
     */
    public function __construct(
        private readonly array $payload,
    ) {
        $text = $this->text();
        $this->parsedArgs = $text !== ''
            ? preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) ?: []
            : [];
    }

    /**
     * Build a SlashCommand from a raw Mattermost webhook payload.
     *
     * @param  array<string, mixed>  $payload
     */
    public static function fromPayload(array $payload): self
    {
        return new self($payload);
    }

    /**
     * The slash command trigger word including the leading slash (e.g. "/deploy").
     */
    public function command(): string
    {
        $command = $this->payload['command'] ?? '';

        return is_string($command) ? $command : '';
    }

    /**
     * The raw text after the command trigger.
     */
    public function text(): string
    {
        $text = $this->payload['text'] ?? '';

        return is_string($text) ? $text : '';
    }

    /**
     * The user ID of the invoking user.
     */
    public function userId(): string
    {
        $userId = $this->payload['user_id'] ?? '';

        return is_string($userId) ? $userId : '';
    }

    /**
     * The username (without @) of the invoking user.
     */
    public function userName(): string
    {
        $userName = $this->payload['user_name'] ?? '';

        return is_string($userName) ? $userName : '';
    }

    /**
     * The channel ID where the command was invoked.
     */
    public function channelId(): string
    {
        $channelId = $this->payload['channel_id'] ?? '';

        return is_string($channelId) ? $channelId : '';
    }

    /**
     * The channel name where the command was invoked.
     */
    public function channelName(): string
    {
        $channelName = $this->payload['channel_name'] ?? '';

        return is_string($channelName) ? $channelName : '';
    }

    /**
     * The team ID where the command was invoked.
     */
    public function teamId(): string
    {
        $teamId = $this->payload['team_id'] ?? '';

        return is_string($teamId) ? $teamId : '';
    }

    /**
     * The verification token sent by Mattermost.
     */
    public function token(): string
    {
        $token = $this->payload['token'] ?? '';

        return is_string($token) ? $token : '';
    }

    /**
     * The response URL for delayed/async responses.
     */
    public function responseUrl(): string
    {
        $url = $this->payload['response_url'] ?? '';

        return is_string($url) ? $url : '';
    }

    /**
     * The trigger ID for opening interactive dialogs.
     */
    public function triggerId(): string
    {
        $id = $this->payload['trigger_id'] ?? '';

        return is_string($id) ? $id : '';
    }

    /**
     * All whitespace-separated arguments from the command text.
     *
     * @return list<string>
     */
    public function args(): array
    {
        return $this->parsedArgs;
    }

    /**
     * Get a single argument by zero-based position, or a default if missing.
     */
    public function arg(int $index, ?string $default = null): ?string
    {
        return $this->parsedArgs[$index] ?? $default;
    }

    /**
     * The raw webhook payload array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->payload;
    }
}
