<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ResetPassword
 *
 * Update the password for a user using a one-use, timed recovery code tied to the user's account. Only
 * works for non-SSO users.
 * ##### Permissions
 * No permissions required.
 */
class ResetPassword extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/password/reset";
	}


	public function __construct()
	{
	}
}
