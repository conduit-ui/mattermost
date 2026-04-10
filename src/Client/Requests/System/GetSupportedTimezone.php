<?php

namespace ConduitUI\Mattermost\Client\Requests\System;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSupportedTimezone
 *
 * __Minimum server version__: 3.10
 * ##### Permissions
 * Must be logged in.
 */
class GetSupportedTimezone extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/system/timezones";
	}


	public function __construct()
	{
	}
}
