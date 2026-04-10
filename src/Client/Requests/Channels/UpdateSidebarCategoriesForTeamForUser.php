<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateSidebarCategoriesForTeamForUser
 *
 * Update any number of sidebar categories for the user on the given team. This can be used to reorder
 * the channels in these categories.
 * __Minimum server version__: 5.26
 * ##### Permissions
 * Must be
 * authenticated and have the `list_team_channels` permission.
 */
class UpdateSidebarCategoriesForTeamForUser extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/channels/categories";
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $teamId,
		protected string $userId,
	) {
	}
}
