<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateChannelScheme
 *
 * Set a channel's scheme, more specifically sets the scheme_id value of a channel record.
 *
 * #####
 * Permissions
 * Must have `manage_system` permission.
 *
 * __Minimum server version__: 4.10
 */
class UpdateChannelScheme extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/scheme";
	}


	/**
	 * @param string $channelId Channel GUID
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
