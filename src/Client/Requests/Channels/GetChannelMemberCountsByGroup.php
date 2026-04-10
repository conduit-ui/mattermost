<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelMemberCountsByGroup
 *
 * Returns a set of ChannelMemberCountByGroup objects which contain a `group_id`,
 * `channel_member_count` and a `channel_member_timezones_count`.
 * ##### Permissions
 * Must have
 * `read_channel` permission for the given channel.
 * __Minimum server version__: 5.24
 */
class GetChannelMemberCountsByGroup extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/member_counts_by_group";
	}


	/**
	 * @param string $channelId Channel GUID
	 * @param null|bool $includeTimezones Defines if member timezone counts should be returned or not
	 */
	public function __construct(
		protected string $channelId,
		protected ?bool $includeTimezones = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['include_timezones' => $this->includeTimezones]);
	}
}
