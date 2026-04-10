<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * AttachDeviceId
 *
 * Attach a mobile device id to the currently logged in session. This will enable push notifications
 * for a user, if configured by the server.
 * ##### Permissions
 * Must be authenticated.
 */
class AttachDeviceId extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/sessions/device";
	}


	public function __construct()
	{
	}
}
