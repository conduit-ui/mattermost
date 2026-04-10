<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserByEmail
 *
 * Get a user object by providing a user email. Sensitive information will be sanitized out.
 * #####
 * Permissions
 * Requires an active session and for the current session to be able to view another user's
 * email based on the server's privacy settings.
 */
class GetUserByEmail extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/email/{$this->email}";
	}


	/**
	 * @param string $email User Email
	 */
	public function __construct(
		protected string $email,
	) {
	}
}
