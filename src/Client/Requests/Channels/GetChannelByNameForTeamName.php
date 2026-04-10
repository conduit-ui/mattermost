<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelByNameForTeamName
 *
 * Gets a channel from the provided team name and channel name strings.
 * #####
 * Permissions
 * `read_channel` permission for the channel.
 */
class GetChannelByNameForTeamName extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/name/{$this->teamName}/channels/name/{$this->channelName}";
	}


	/**
	 * @param string $teamName Team Name
	 * @param string $channelName Channel Name
	 * @param null|bool $includeDeleted Defines if deleted channels should be returned or not (Mattermost Server 5.26.0+)
	 */
	public function __construct(
		protected string $teamName,
		protected string $channelName,
		protected ?bool $includeDeleted = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['include_deleted' => $this->includeDeleted]);
	}
}
