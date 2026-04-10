<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamMember
 *
 * Get a team member on the system.
 * ##### Permissions
 * Must be authenticated and have the `view_team`
 * permission.
 */
class GetTeamMember extends Request
{
	protected Method $method = Method::GET;


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
