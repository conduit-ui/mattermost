<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateChannelPrivacy
 *
 * Updates channel's privacy allowing changing a channel from Public to Private and back.
 *
 * __Minimum
 * server version__: 5.16
 *
 * ##### Permissions
 * `manage_team` permission for the channels team on version
 * < 5.28. `convert_public_channel_to_private` permission for the channel if updating privacy to 'P' on
 * version >= 5.28. `convert_private_channel_to_public` permission for the channel if updating privacy
 * to 'O' on version >= 5.28.
 */
class UpdateChannelPrivacy extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/privacy";
	}


	/**
	 * @param string $channelId Channel GUID
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
