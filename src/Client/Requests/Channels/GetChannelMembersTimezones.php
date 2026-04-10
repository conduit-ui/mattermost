<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelMembersTimezones
 *
 * Get a list of timezones for the users who are in this channel.
 *
 * __Minimum server version__:
 * 5.6
 *
 * ##### Permissions
 * Must have the `read_channel` permission.
 */
class GetChannelMembersTimezones extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/timezones";
	}


	/**
	 * @param string $channelId Channel GUID
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
