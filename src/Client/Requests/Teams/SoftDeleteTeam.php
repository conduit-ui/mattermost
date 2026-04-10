<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * SoftDeleteTeam
 *
 * Soft deletes a team, by marking the team as deleted in the database. Soft deleted teams will not be
 * accessible in the user interface.
 *
 * Optionally use the permanent query parameter to hard delete the
 * team for compliance reasons. As of server version 5.0, to use this feature
 * `ServiceSettings.EnableAPITeamDeletion` must be set to `true` in the server's configuration.
 * #####
 * Permissions
 * Must have the `manage_team` permission.
 */
class SoftDeleteTeam extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}";
	}


	/**
	 * @param string $teamId Team GUID
	 * @param null|bool $permanent Permanently delete the team, to be used for compliance reasons only. As of server version 5.0, `ServiceSettings.EnableAPITeamDeletion` must be set to `true` in the server's configuration.
	 */
	public function __construct(
		protected string $teamId,
		protected ?bool $permanent = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['permanent' => $this->permanent]);
	}
}
