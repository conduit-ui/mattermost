<?php

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * UnpinPost
 *
 * Unpin a post to a channel it is in based from the provided post id string.
 * ##### Permissions
 * Must be
 * authenticated and have the `read_channel` permission to the channel the post is in.
 */
class UnpinPost extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/posts/{$this->postId}/unpin";
	}


	/**
	 * @param string $postId Post GUID
	 */
	public function __construct(
		protected string $postId,
	) {
	}
}
