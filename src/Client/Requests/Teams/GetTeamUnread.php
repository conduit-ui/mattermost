<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamUnread
 *
 * Get the unread mention and message counts for a team for the specified user.
 * ##### Permissions
 * Must
 * be the user or have `edit_other_users` permission and have `view_team` permission for the team.
 */
class GetTeamUnread extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/unread";
	}


	/**
	 * @param string $userId User GUID
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $userId,
		protected string $teamId,
	) {
	}
}
