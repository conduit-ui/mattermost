<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelMember
 *
 * Get a channel member.
 * ##### Permissions
 * `read_channel` permission for the channel.
 */
class GetChannelMember extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/members/{$this->userId}";
	}


	/**
	 * @param string $channelId Channel GUID
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $channelId,
		protected string $userId,
	) {
	}
}
