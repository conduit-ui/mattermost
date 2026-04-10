<?php

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ConvertUserToBot
 *
 * Convert a user into a bot.
 *
 * __Minimum server version__: 5.26
 *
 * ##### Permissions
 * Must have
 * `manage_system` permission.
 */
class ConvertUserToBot extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/convert_to_bot";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
