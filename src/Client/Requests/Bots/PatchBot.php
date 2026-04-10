<?php

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PatchBot
 *
 * Partially update a bot by providing only the fields you want to update. Omitted fields will not be
 * updated. The fields that can be updated are defined in the request body, all other provided fields
 * will be ignored.
 * ##### Permissions
 * Must have `manage_bots` permission.
 * __Minimum server version__:
 * 5.10
 */
class PatchBot extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/bots/{$this->botUserId}";
	}


	/**
	 * @param string $botUserId Bot user ID
	 */
	public function __construct(
		protected string $botUserId,
	) {
	}
}
