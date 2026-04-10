<?php

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PatchPost
 *
 * Partially update a post by providing only the fields you want to update. Omitted fields will not be
 * updated. The fields that can be updated are defined in the request body, all other provided fields
 * will be ignored.
 * ##### Permissions
 * Must have the `edit_post` permission.
 */
class PatchPost extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/posts/{$this->postId}/patch";
	}


	/**
	 * @param string $postId Post GUID
	 */
	public function __construct(
		protected string $postId,
	) {
	}
}
