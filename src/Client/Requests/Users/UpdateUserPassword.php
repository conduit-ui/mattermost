<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserPassword
 *
 * Update a user's password. New password must meet password policy set by server configuration.
 * Current password is required if you're updating your own password.
 * ##### Permissions
 * Must be logged
 * in as the user the password is being changed for or have `manage_system` permission.
 */
class UpdateUserPassword extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/password";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
