<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RegenerateTeamInviteId
 *
 * Regenerates the invite ID used in invite links of a team
 * ##### Permissions
 * Must be authenticated and
 * have the `manage_team` permission.
 */
class RegenerateTeamInviteId extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/regenerate_invite_id";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
