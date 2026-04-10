<?php

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * DoPostAction
 *
 * Perform a post action, which allows users to interact with integrations through posts.
 * #####
 * Permissions
 * Must be authenticated and have the `read_channel` permission to the channel the post is
 * in.
 */
class DoPostAction extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/posts/{$this->postId}/actions/{$this->actionId}";
	}


	/**
	 * @param string $postId Post GUID
	 * @param string $actionId Action GUID
	 */
	public function __construct(
		protected string $postId,
		protected string $actionId,
	) {
	}
}
