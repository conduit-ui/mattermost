<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetKnownUsers
 *
 * Get the list of user IDs of users with any direct relationship with a
 * user. That means any user
 * sharing any channel, including direct and
 * group channels.
 * ##### Permissions
 * Must be
 * authenticated.
 *
 * __Minimum server version__: 5.23
 */
class GetKnownUsers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/known";
	}


	public function __construct()
	{
	}
}
