<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CheckUserMfa
 *
 * Check if a user has multi-factor authentication active on their account by providing a login id.
 * Used to check whether an MFA code needs to be provided when logging in.
 * ##### Permissions
 * No
 * permission required.
 */
class CheckUserMfa extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/mfa";
	}


	public function __construct()
	{
	}
}
