<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddChannelMember
 *
 * Add a user to a channel by creating a channel member object.
 */
class AddChannelMember extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/members";
	}


	/**
	 * @param string $channelId The channel ID
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
