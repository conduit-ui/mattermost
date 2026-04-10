<?php

namespace ConduitUI\Mattermost\Client\Requests\Threads;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateThreadReadForUser
 *
 * Mark a thread that user is following as read
 *
 * __Minimum server version__: 5.29
 *
 * #####
 * Permissions
 * Must be logged in as the user or have `edit_other_users` permission.
 */
class UpdateThreadReadForUser extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/threads/{$this->threadId}/read/{$this->timestamp}";
	}


	/**
	 * @param string $userId The ID of the user. This can also be "me" which will point to the current user.
	 * @param string $teamId The ID of the team in which the thread is.
	 * @param string $threadId The ID of the thread to update
	 * @param string $timestamp The timestamp to which the thread's "last read" state will be reset.
	 */
	public function __construct(
		protected string $userId,
		protected string $teamId,
		protected string $threadId,
		protected string $timestamp,
	) {
	}
}
