<?php

namespace ConduitUI\Mattermost\Client\Requests\Status;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UnsetUserCustomStatus
 *
 * Unsets a user's custom status by updating the user's props and updates the user
 * #####
 * Permissions
 * Must be logged in as the user whose custom status is being removed.
 */
class UnsetUserCustomStatus extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/status/custom";
	}


	/**
	 * @param string $userId User ID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
