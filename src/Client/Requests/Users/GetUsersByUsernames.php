<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetUsersByUsernames
 *
 * Get a list of users based on a provided list of usernames.
 * ##### Permissions
 * Requires an active
 * session but no other permissions.
 */
class GetUsersByUsernames extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/usernames";
	}


	public function __construct()
	{
	}
}
