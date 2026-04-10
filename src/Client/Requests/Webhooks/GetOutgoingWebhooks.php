<?php

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetOutgoingWebhooks
 *
 * Get a page of a list of outgoing webhooks. Optionally filter for a specific team or channel using
 * query parameters.
 * ##### Permissions
 * `manage_webhooks` for the system or `manage_webhooks` for the
 * specific team/channel.
 */
class GetOutgoingWebhooks extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/hooks/outgoing";
	}


	/**
	 * @param null|int $page The page to select.
	 * @param null|string $teamId The ID of the team to get hooks for.
	 * @param null|string $channelId The ID of the channel to get hooks for.
	 */
	public function __construct(
		protected ?int $page = null,
		protected ?string $teamId = null,
		protected ?string $channelId = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['page' => $this->page, 'team_id' => $this->teamId, 'channel_id' => $this->channelId]);
	}
}
