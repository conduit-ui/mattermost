<?php

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateCommand
 *
 * Update a single command based on command id string and Command struct.
 * ##### Permissions
 * Must have
 * `manage_slash_commands` permission for the team the command is in.
 */
class UpdateCommand extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/commands/{$this->commandId}";
	}


	/**
	 * @param string $commandId ID of the command to update
	 */
	public function __construct(
		protected string $commandId,
	) {
	}
}
