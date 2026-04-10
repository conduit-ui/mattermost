<?php

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPost
 *
 * Get a single post.
 * ##### Permissions
 * Must have `read_channel` permission for the channel the post is
 * in or if the channel is public, have the `read_public_channels` permission for the team.
 */
class GetPost extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/posts/{$this->postId}";
	}


	/**
	 * @param string $postId ID of the post to get
	 * @param null|bool $includeDeleted Defines if result should include deleted posts, must have 'manage_system' (admin) permission.
	 */
	public function __construct(
		protected string $postId,
		protected ?bool $includeDeleted = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['include_deleted' => $this->includeDeleted]);
	}
}
