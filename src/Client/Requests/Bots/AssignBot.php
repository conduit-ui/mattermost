<?php

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AssignBot
 *
 * Assign a bot to a specified user.
 * ##### Permissions
 * Must have `manage_bots` permission.
 * __Minimum
 * server version__: 5.10
 */
class AssignBot extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/bots/{$this->botUserId}/assign/{$this->userId}";
	}


	/**
	 * @param string $botUserId Bot user ID
	 * @param string $userId The user ID to assign the bot to.
	 */
	public function __construct(
		protected string $botUserId,
		protected string $userId,
	) {
	}
}
