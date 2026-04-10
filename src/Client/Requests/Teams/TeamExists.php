<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * TeamExists
 *
 * Check if the team exists based on a team name.
 * ##### Permissions
 * Must be authenticated.
 */
class TeamExists extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/name/{$this->name}/exists";
	}


	/**
	 * @param string $name Team Name
	 */
	public function __construct(
		protected string $name,
	) {
	}
}
