<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Interactive;

/**
 * Value object representing an incoming Mattermost interactive action payload.
 *
 * Mattermost POSTs a JSON payload when a user clicks a button or selects a
 * menu option on an interactive message attachment. This DTO wraps that
 * payload and provides typed convenience accessors.
 */
class InteractiveAction
{
    /**
     * @param  array<string, mixed>  $payload  The raw webhook payload.
     */
    public function __construct(
        private readonly array $payload,
    ) {}

    /**
     * Build an InteractiveAction from a raw Mattermost webhook payload.
     *
     * @param  array<string, mixed>  $payload
     */
    public static function fromPayload(array $payload): self
    {
        return new self($payload);
    }

    /**
     * The action ID identifying which button or menu option was triggered.
     *
     * Mattermost passes the integration's `context` object back through the
     * webhook unchanged. By convention this package keys the action name as
     * `context.action`, set when registering the button via the message
     * builder's `integration.context.action` field.
     */
    public function actionId(): string
    {
        $action = $this->payload['context']['action'] ?? '';

        return is_string($action) ? $action : '';
    }

    /**
     * The value associated with the action — read from `context.value` since
     * Mattermost does not surface a top-level `value` field on the webhook.
     */
    public function value(): mixed
    {
        return $this->payload['context']['value'] ?? null;
    }

    /**
     * The type of interactive element ("button" or "select").
     */
    public function type(): string
    {
        $type = $this->payload['type'] ?? '';

        return is_string($type) ? $type : '';
    }

    /**
     * The user ID of the user who triggered the action.
     */
    public function userId(): string
    {
        $userId = $this->payload['user_id'] ?? '';

        return is_string($userId) ? $userId : '';
    }

    /**
     * The username (without @) of the user who triggered the action.
     */
    public function userName(): string
    {
        $userName = $this->payload['user_name'] ?? '';

        return is_string($userName) ? $userName : '';
    }

    /**
     * The channel ID where the interactive message was posted.
     */
    public function channelId(): string
    {
        $channelId = $this->payload['channel_id'] ?? '';

        return is_string($channelId) ? $channelId : '';
    }

    /**
     * The channel name where the interactive message was posted.
     */
    public function channelName(): string
    {
        $channelName = $this->payload['channel_name'] ?? '';

        return is_string($channelName) ? $channelName : '';
    }

    /**
     * The post ID of the message containing the action.
     */
    public function postId(): string
    {
        $postId = $this->payload['post_id'] ?? '';

        return is_string($postId) ? $postId : '';
    }

    /**
     * The team ID where the action was triggered.
     */
    public function teamId(): string
    {
        $teamId = $this->payload['team_id'] ?? '';

        return is_string($teamId) ? $teamId : '';
    }

    /**
     * The team domain where the action was triggered.
     */
    public function teamDomain(): string
    {
        $domain = $this->payload['team_domain'] ?? '';

        return is_string($domain) ? $domain : '';
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
     * The data source for select menus (e.g. "users", "channels").
     */
    public function dataSource(): string
    {
        $source = $this->payload['data_source'] ?? '';

        return is_string($source) ? $source : '';
    }

    /**
     * Custom context data passed through the integration payload.
     *
     * @return array<string, mixed>
     */
    public function context(): array
    {
        $context = $this->payload['context'] ?? [];

        return is_array($context) ? $context : [];
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
