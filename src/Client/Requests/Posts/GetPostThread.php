<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPostThread
 *
 * Get a post and the rest of the posts in the same thread.
 * ##### Permissions
 * Must have `read_channel`
 * permission for the channel the post is in or if the channel is public, have the
 * `read_public_channels` permission for the team.
 */
class GetPostThread extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}/thread";
    }

    /**
     * @param  string  $postId  ID of a post in the thread
     * @param  null|int  $perPage  The number of posts per page
     * @param  null|string  $fromPost  The post_id to return the next page of posts from
     * @param  null|int  $fromCreateAt  The create_at timestamp to return the next page of posts from
     * @param  null|string  $direction  The direction to return the posts. Either up or down.
     * @param  null|bool  $skipFetchThreads  Whether to skip fetching threads or not
     * @param  null|bool  $collapsedThreads  Whether the client uses CRT or not
     * @param  null|bool  $collapsedThreadsExtended  Whether to return the associated users as part of the response or not
     */
    public function __construct(
        protected string $postId,
        protected ?int $perPage = null,
        protected ?string $fromPost = null,
        protected ?int $fromCreateAt = null,
        protected ?string $direction = null,
        protected ?bool $skipFetchThreads = null,
        protected ?bool $collapsedThreads = null,
        protected ?bool $collapsedThreadsExtended = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'perPage' => $this->perPage,
            'fromPost' => $this->fromPost,
            'fromCreateAt' => $this->fromCreateAt,
            'direction' => $this->direction,
            'skipFetchThreads' => $this->skipFetchThreads,
            'collapsedThreads' => $this->collapsedThreads,
            'collapsedThreadsExtended' => $this->collapsedThreadsExtended,
        ]);
    }
}
