<?php

namespace ConduitUI\Mattermost\Client\Requests\Status;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserStatus
 *
 * Manually set a user's status. When setting a user's status, the status will remain that value until
 * set "online" again, which will return the status to being automatically updated based on user
 * activity.
 * ##### Permissions
 * Must have `edit_other_users` permission for the team.
 */
class UpdateUserStatus extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/status";
	}


	/**
	 * @param string $userId User ID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
