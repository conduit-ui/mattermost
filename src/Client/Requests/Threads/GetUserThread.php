<?php

namespace ConduitUI\Mattermost\Client\Requests\Threads;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserThread
 *
 * Get a thread
 *
 * __Minimum server version__: 5.29
 *
 * ##### Permissions
 * Must be logged in as the user or
 * have `edit_other_users` permission.
 */
class GetUserThread extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/threads/{$this->threadId}";
	}


	/**
	 * @param string $userId The ID of the user. This can also be "me" which will point to the current user.
	 * @param string $teamId The ID of the team in which the thread is.
	 * @param string $threadId The ID of the thread to follow
	 */
	public function __construct(
		protected string $userId,
		protected string $teamId,
		protected string $threadId,
	) {
	}
}
