<?php

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * DisableBot
 *
 * Disable a bot.
 * ##### Permissions
 * Must have `manage_bots` permission.
 * __Minimum server version__:
 * 5.10
 */
class DisableBot extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/bots/{$this->botUserId}/disable";
	}


	/**
	 * @param string $botUserId Bot user ID
	 */
	public function __construct(
		protected string $botUserId,
	) {
	}
}
