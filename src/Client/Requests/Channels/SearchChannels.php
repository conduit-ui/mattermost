<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchChannels
 *
 * Search public channels on a team based on the search term provided in the request body.
 * #####
 * Permissions
 * Must have the `list_team_channels` permission.
 *
 * In server version 5.16 and later, a user
 * without the `list_team_channels` permission will be able to use this endpoint, with the search
 * results limited to the channels that the user is a member of.
 */
class SearchChannels extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/channels/search";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
