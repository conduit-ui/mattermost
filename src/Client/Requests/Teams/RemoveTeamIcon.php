<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * RemoveTeamIcon
 *
 * Remove the team icon for the team.
 *
 * __Minimum server version__: 4.10
 *
 * ##### Permissions
 * Must be
 * authenticated and have the `manage_team` permission.
 */
class RemoveTeamIcon extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/image";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
