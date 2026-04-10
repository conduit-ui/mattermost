<?php

namespace ConduitUI\Mattermost\Client\Requests\System;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * MarkNoticesViewed
 *
 * Will mark the specified notices as 'viewed' by the logged in user.
 * __Minimum server version__:
 * 5.26
 * ##### Permissions
 * Must be logged in.
 */
class MarkNoticesViewed extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/system/notices/view";
	}


	public function __construct()
	{
	}
}
