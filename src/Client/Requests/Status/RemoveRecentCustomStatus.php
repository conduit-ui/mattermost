<?php

namespace ConduitUI\Mattermost\Client\Requests\Status;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * RemoveRecentCustomStatus
 *
 * Deletes a user's recent custom status by removing the specific status from the recentCustomStatuses
 * in the user's props and updates the user.
 * ##### Permissions
 * Must be logged in as the user whose
 * recent custom status is being deleted.
 */
class RemoveRecentCustomStatus extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/status/custom/recent";
	}


	/**
	 * @param string $userId User ID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
