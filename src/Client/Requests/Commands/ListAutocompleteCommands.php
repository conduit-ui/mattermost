<?php

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ListAutocompleteCommands
 *
 * List autocomplete commands in the team.
 * ##### Permissions
 * `view_team` for the team.
 */
class ListAutocompleteCommands extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/commands/autocomplete";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
