<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateTeamMemberSchemeRoles
 *
 * Update a team member's scheme_admin/scheme_user properties. Typically this should either be
 * `scheme_admin=false, scheme_user=true` for ordinary team member, or `scheme_admin=true,
 * scheme_user=true` for a team admin.
 *
 * __Minimum server version__: 5.0
 *
 * ##### Permissions
 * Must be
 * authenticated and have the `manage_team_roles` permission.
 */
class UpdateTeamMemberSchemeRoles extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/members/{$this->userId}/schemeRoles";
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
