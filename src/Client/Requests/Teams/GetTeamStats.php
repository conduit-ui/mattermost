<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamStats
 *
 * Get a team stats on the system.
 * ##### Permissions
 * Must be authenticated and have the `view_team`
 * permission.
 */
class GetTeamStats extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/stats";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
