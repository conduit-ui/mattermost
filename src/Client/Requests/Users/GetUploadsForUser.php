<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUploadsForUser
 *
 * Gets all the upload sessions belonging to a user.
 *
 * __Minimum server version__: 5.28
 *
 * #####
 * Permissions
 * Must be logged in as the user who created the upload sessions.
 */
class GetUploadsForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/uploads";
	}


	/**
	 * @param string $userId The ID of the user. This can also be "me" which will point to the current user.
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
