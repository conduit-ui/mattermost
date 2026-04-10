<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * AutocompleteUsers
 *
 * Get a list of users for the purpose of autocompleting based on the provided search term. Specify a
 * combination of `team_id` and `channel_id` to filter results further.
 * ##### Permissions
 * Requires an
 * active session and `view_team` and `read_channel` on any teams or channels used to filter the
 * results further.
 */
class AutocompleteUsers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/autocomplete";
	}


	/**
	 * @param null|string $teamId Team ID
	 * @param null|string $channelId Channel ID
	 * @param string $name Username, nickname first name or last name
	 * @param null|int $limit The maximum number of users to return in each subresult
	 *
	 * __Available as of server version 5.6. Defaults to `100` if not provided or on an earlier server version.__
	 */
	public function __construct(
		protected ?string $teamId = null,
		protected ?string $channelId = null,
		protected string $name,
		protected ?int $limit = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['team_id' => $this->teamId, 'channel_id' => $this->channelId, 'name' => $this->name, 'limit' => $this->limit]);
	}
}
