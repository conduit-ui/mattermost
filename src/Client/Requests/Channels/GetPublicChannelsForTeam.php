<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPublicChannelsForTeam
 *
 * Get a page of public channels on a team based on query string parameters - page and per_page.
 * #####
 * Permissions
 * Must be authenticated and have the `list_team_channels` permission.
 */
class GetPublicChannelsForTeam extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/channels";
	}


	/**
	 * @param string $teamId Team GUID
	 * @param null|int $page The page to select.
	 */
	public function __construct(
		protected string $teamId,
		protected ?int $page = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['page' => $this->page]);
	}
}
