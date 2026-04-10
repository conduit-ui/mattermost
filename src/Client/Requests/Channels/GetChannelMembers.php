<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelMembers
 *
 * Get a page of members for a channel.
 * ##### Permissions
 * `read_channel` permission for the channel.
 */
class GetChannelMembers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/members";
	}


	/**
	 * @param string $channelId Channel GUID
	 * @param null|int $page The page to select.
	 */
	public function __construct(
		protected string $channelId,
		protected ?int $page = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['page' => $this->page]);
	}
}
