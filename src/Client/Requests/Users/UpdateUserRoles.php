<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserRoles
 *
 * Update a user's system-level roles. Valid user roles are "system_user", "system_admin" or both of
 * them. Overwrites any previously assigned system-level roles.
 * ##### Permissions
 * Must have the
 * `manage_roles` permission.
 */
class UpdateUserRoles extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/roles";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
