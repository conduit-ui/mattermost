<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPostsForChannel
 *
 * Get a page of posts in a channel. Use the query parameters to modify the behaviour of this endpoint.
 * The parameter `since` must not be used with any of `before`, `after`, `page`, and `per_page`
 * parameters.
 * If `since` is used, it will always return all posts modified since that time, ordered by
 * their create time limited till 1000. A caveat with this parameter is that there is no guarantee that
 * the returned posts will be consecutive. It is left to the clients to maintain state and fill any
 * missing holes in the post order.
 * ##### Permissions
 * Must have `read_channel` permission for the
 * channel.
 */
class GetPostsForChannel extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/posts";
    }

    /**
     * @param  string  $channelId  The channel ID to get the posts for
     * @param  null|int  $page  The page to select
     * @param  null|int  $since  Provide a non-zero value in Unix time milliseconds to select posts modified after that time
     * @param  null|string  $before  A post id to select the posts that came before this one
     * @param  null|bool  $includeDeleted  Whether to include deleted posts or not. Must have system admin permissions.
     */
    public function __construct(
        protected string $channelId,
        protected ?int $page = null,
        protected ?int $since = null,
        protected ?string $before = null,
        protected ?bool $includeDeleted = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'since' => $this->since, 'before' => $this->before, 'include_deleted' => $this->includeDeleted]);
    }
}
