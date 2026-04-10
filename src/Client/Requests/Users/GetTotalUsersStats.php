<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTotalUsersStats
 *
 * Get a total count of users in the system.
 * ##### Permissions
 * Must be authenticated.
 */
class GetTotalUsersStats extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/stats";
	}


	public function __construct()
	{
	}
}
