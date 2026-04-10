<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamsForUser
 *
 * Get a list of teams that a user is on.
 * ##### Permissions
 * Must be authenticated as the user or have
 * the `manage_system` permission.
 */
class GetTeamsForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
