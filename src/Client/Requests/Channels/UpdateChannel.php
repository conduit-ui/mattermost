<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateChannel
 *
 * Update a channel. The fields that can be updated are listed as parameters. Omitted fields will be
 * treated as blanks.
 * ##### Permissions
 * If updating a public channel, `manage_public_channel_members`
 * permission is required. If updating a private channel, `manage_private_channel_members` permission
 * is required.
 */
class UpdateChannel extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}";
	}


	/**
	 * @param string $channelId Channel GUID
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
