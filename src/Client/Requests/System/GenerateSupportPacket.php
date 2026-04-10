<?php

namespace ConduitUI\Mattermost\Client\Requests\System;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GenerateSupportPacket
 *
 * Download a zip file which contains helpful and useful information for troubleshooting your
 * mattermost instance.
 * __Minimum server version: 5.32__
 * ##### Permissions
 * Must have any of the system
 * console read permissions.
 * ##### License
 * Requires either a E10 or E20 license.
 */
class GenerateSupportPacket extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/system/support_packet";
	}


	public function __construct()
	{
	}
}
