<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelsForTeamForUser
 *
 * Get all the channels on a team for a user.
 * ##### Permissions
 * Logged in as the user, or have
 * `edit_other_users` permission, and `view_team` permission for the team.
 */
class GetChannelsForTeamForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/channels";
	}


	/**
	 * @param string $userId User GUID
	 * @param string $teamId Team GUID
	 * @param null|bool $includeDeleted Defines if deleted channels should be returned or not
	 * @param null|int $lastDeleteAt Filters the deleted channels by this time in epoch format. Does not have any effect if include_deleted is set to false.
	 */
	public function __construct(
		protected string $userId,
		protected string $teamId,
		protected ?bool $includeDeleted = null,
		protected ?int $lastDeleteAt = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['include_deleted' => $this->includeDeleted, 'last_delete_at' => $this->lastDeleteAt]);
	}
}
