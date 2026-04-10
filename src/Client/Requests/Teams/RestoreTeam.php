<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RestoreTeam
 *
 * Restore a team that was previously soft deleted.
 *
 * __Minimum server version__: 5.24
 *
 * #####
 * Permissions
 * Must have the `manage_team` permission.
 */
class RestoreTeam extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/restore";
	}


	/**
	 * @param string $teamId Team GUID
	 */
	public function __construct(
		protected string $teamId,
	) {
	}
}
