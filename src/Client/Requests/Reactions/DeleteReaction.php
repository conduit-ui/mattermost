<?php

namespace ConduitUI\Mattermost\Client\Requests\Reactions;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteReaction
 *
 * Deletes a reaction made by a user from the given post.
 * ##### Permissions
 * Must be user or have
 * `manage_system` permission.
 */
class DeleteReaction extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/posts/{$this->postId}/reactions/{$this->emojiName}";
	}


	/**
	 * @param string $userId ID of the user
	 * @param string $postId ID of the post
	 * @param string $emojiName emoji name
	 */
	public function __construct(
		protected string $userId,
		protected string $postId,
		protected string $emojiName,
	) {
	}
}
