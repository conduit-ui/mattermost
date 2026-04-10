<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetPrivateChannelsForTeam
 *
 * Get a page of private channels on a team based on query string
 * parameters - team_id, page and
 * per_page.
 *
 * __Minimum server version__: 5.26
 *
 * ##### Permissions
 * Must have `manage_system`
 * permission.
 */
class GetPrivateChannelsForTeam extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/channels/private";
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
