<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateChannel
 *
 * Create a new channel.
 * ##### Permissions
 * If creating a public channel, `create_public_channel`
 * permission is required. If creating a private channel, `create_private_channel` permission is
 * required.
 */
class CreateChannel extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels";
	}


	public function __construct()
	{
	}
}
