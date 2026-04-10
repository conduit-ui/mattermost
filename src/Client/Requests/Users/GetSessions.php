<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSessions
 *
 * Get a list of sessions by providing the user GUID. Sensitive information will be sanitized
 * out.
 * ##### Permissions
 * Must be logged in as the user being updated or have the `edit_other_users`
 * permission.
 */
class GetSessions extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/sessions";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
