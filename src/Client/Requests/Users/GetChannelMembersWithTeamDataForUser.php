<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelMembersWithTeamDataForUser
 *
 * Get all channel members from all teams for a user.
 *
 * __Minimum server version__: 6.2.0
 *
 * #####
 * Permissions
 * Logged in as the user, or have `edit_other_users` permission.
 */
class GetChannelMembersWithTeamDataForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/channel_members";
	}


	/**
	 * @param string $userId The ID of the user. This can also be "me" which will point to the current user.
	 * @param null|int $page Page specifies which part of the results to return, by PageSize.
	 * @param null|int $pageSize PageSize specifies the size of the returned chunk of results.
	 */
	public function __construct(
		protected string $userId,
		protected ?int $page = null,
		protected ?int $pageSize = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['page' => $this->page, 'pageSize' => $this->pageSize]);
	}
}
