<?php

namespace ConduitUI\Mattermost\Client\Requests\Status;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserStatus
 *
 * Get user status by id from the server.
 * ##### Permissions
 * Must be authenticated.
 */
class GetUserStatus extends Request
{
	protected Method $method = Method::GET;


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
