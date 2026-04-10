<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserMfa
 *
 * Activates multi-factor authentication for the user if `activate` is true and a valid `code` is
 * provided. If activate is false, then `code` is not required and multi-factor authentication is
 * disabled for the user.
 * ##### Permissions
 * Must be logged in as the user being updated or have the
 * `edit_other_users` permission.
 */
class UpdateUserMfa extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/mfa";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
