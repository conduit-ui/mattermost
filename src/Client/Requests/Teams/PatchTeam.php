<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PatchTeam
 *
 * Partially update a team by providing only the fields you want to update. Omitted fields will not be
 * updated. The fields that can be updated are defined in the request body, all other provided fields
 * will be ignored.
 * ##### Permissions
 * Must have the `manage_team` permission.
 */
class PatchTeam extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/patch";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
