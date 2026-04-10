<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * AutocompleteChannelsForTeam
 *
 * Autocomplete public channels on a team based on the search term provided in the request
 * URL.
 *
 * __Minimum server version__: 4.7
 *
 * ##### Permissions
 * Must have the `list_team_channels`
 * permission.
 */
class AutocompleteChannelsForTeam extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/channels/autocomplete";
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $name Name or display name
	 */
	public function __construct(
		protected string $teamId,
		protected string $name,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['name' => $this->name]);
	}
}
