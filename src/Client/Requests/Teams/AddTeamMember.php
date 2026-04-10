<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddTeamMember
 *
 * Add user to the team by user_id.
 * ##### Permissions
 * Must be authenticated and team be open to add
 * self. For adding another user, authenticated user must have the `add_user_to_team` permission.
 */
class AddTeamMember extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/members";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
