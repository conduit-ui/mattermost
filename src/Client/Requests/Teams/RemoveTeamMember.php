<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * RemoveTeamMember
 *
 * Delete the team member object for a user, effectively removing them from a team.
 * #####
 * Permissions
 * Must be logged in as the user or have the `remove_user_from_team` permission.
 */
class RemoveTeamMember extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/members/{$this->userId}";
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $teamId,
		protected string $userId,
	) {
	}
}
