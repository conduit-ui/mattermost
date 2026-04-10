<?php

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * RegenCommandToken
 *
 * Generate a new token for the command based on command id string.
 * ##### Permissions
 * Must have
 * `manage_slash_commands` permission for the team the command is in.
 */
class RegenCommandToken extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/commands/{$this->commandId}/regen_token";
	}


	/**
	 * @param string $commandId ID of the command to generate the new token
	 */
	public function __construct(
		protected string $commandId,
	) {
	}
}
