<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SendPasswordResetEmail
 *
 * Send an email containing a link for resetting the user's password. The link will contain a one-use,
 * timed recovery code tied to the user's account. Only works for non-SSO users.
 * ##### Permissions
 * No
 * permissions required.
 */
class SendPasswordResetEmail extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/password/reset/send";
	}


	public function __construct()
	{
	}
}
