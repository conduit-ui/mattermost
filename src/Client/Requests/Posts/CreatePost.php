<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreatePost
 *
 * Create a new post in a channel. To create the post as a comment on another post, provide
 * `root_id`.
 * ##### Permissions
 * Must have `create_post` permission for the channel the post is being
 * created in.
 *
 * Auto-gen gap: the generator emitted the request with no JSON body parameters. The
 * Mattermost OpenAPI spec defines `channel_id`, `message`, `root_id`, `file_ids`, and
 * `props` for `POST /api/v4/posts`, so they are wired up here so callers (notification
 * channel, broadcaster, etc.) can actually create posts.
 */
class CreatePost extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/posts';
    }

    /**
     * @param  string|null  $channelId  The channel ID to post to.
     * @param  string|null  $message  The message contents (markdown supported).
     * @param  string|null  $rootId  The post ID to reply to. Creates a thread reply.
     * @param  array<int, string>|null  $fileIds  IDs of uploaded files to attach.
     * @param  array<string, mixed>|null  $props  Custom properties (e.g. `attachments`).
     * @param  bool|null  $setOnline  Whether to set the user status as online or not.
     */
    public function __construct(
        protected ?string $channelId = null,
        protected ?string $message = null,
        protected ?string $rootId = null,
        protected ?array $fileIds = null,
        protected ?array $props = null,
        protected ?bool $setOnline = null,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function defaultQuery(): array
    {
        return array_filter(['set_online' => $this->setOnline], static fn (?bool $v): bool => $v !== null);
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return array_filter(
            [
                'channel_id' => $this->channelId,
                'message' => $this->message,
                'root_id' => $this->rootId,
                'file_ids' => $this->fileIds,
                'props' => $this->props,
            ],
            static fn (string|array|null $v): bool => $v !== null,
        );
    }
}
