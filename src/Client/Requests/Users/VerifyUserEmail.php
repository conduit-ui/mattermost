<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * VerifyUserEmail
 *
 * Verify the email used by a user to sign-up their account with.
 * ##### Permissions
 * No permissions
 * required.
 */
class VerifyUserEmail extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/email/verify";
	}


	public function __construct()
	{
	}
}
