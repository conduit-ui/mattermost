<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateSidebarCategoryForTeamForUser
 *
 * Create a custom sidebar category for the user on the given team.
 * __Minimum server version__:
 * 5.26
 * ##### Permissions
 * Must be authenticated and have the `list_team_channels` permission.
 */
class CreateSidebarCategoryForTeamForUser extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


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
