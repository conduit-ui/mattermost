<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeam
 *
 * Get a team on the system.
 * ##### Permissions
 * Must be authenticated and have the `view_team`
 * permission.
 */
class GetTeam extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
