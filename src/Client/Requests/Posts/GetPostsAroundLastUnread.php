<?php

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPostsAroundLastUnread
 *
 * Get the oldest unread post in the channel for the given user as well as the posts around it. The
 * returned list is sorted in descending order (most recent post first).
 * ##### Permissions
 * Must be
 * logged in as the user or have `edit_other_users` permission, and must have `read_channel` permission
 * for the channel.
 * __Minimum server version__: 5.14
 */
class GetPostsAroundLastUnread extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/channels/{$this->channelId}/posts/unread";
	}


	/**
	 * @param string $userId ID of the user
	 * @param string $channelId The channel ID to get the posts for
	 * @param null|int $limitBefore Number of posts before the oldest unread posts. Maximum is 200 posts if limit is set greater than that.
	 * @param null|int $limitAfter Number of posts after and including the oldest unread post. Maximum is 200 posts if limit is set greater than that.
	 * @param null|bool $skipFetchThreads Whether to skip fetching threads or not
	 * @param null|bool $collapsedThreads Whether the client uses CRT or not
	 * @param null|bool $collapsedThreadsExtended Whether to return the associated users as part of the response or not
	 */
	public function __construct(
		protected string $userId,
		protected string $channelId,
		protected ?int $limitBefore = null,
		protected ?int $limitAfter = null,
		protected ?bool $skipFetchThreads = null,
		protected ?bool $collapsedThreads = null,
		protected ?bool $collapsedThreadsExtended = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'limit_before' => $this->limitBefore,
			'limit_after' => $this->limitAfter,
			'skipFetchThreads' => $this->skipFetchThreads,
			'collapsedThreads' => $this->collapsedThreads,
			'collapsedThreadsExtended' => $this->collapsedThreadsExtended,
		]);
	}
}
