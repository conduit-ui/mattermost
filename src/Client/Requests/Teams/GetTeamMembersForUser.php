<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamMembersForUser
 *
 * Get a list of team members for a user. Useful for getting the ids of teams the user is on and the
 * roles they have in those teams.
 * ##### Permissions
 * Must be logged in as the user or have the
 * `edit_other_users` permission.
 */
class GetTeamMembersForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/members";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
