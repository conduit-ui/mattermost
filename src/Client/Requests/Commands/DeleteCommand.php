<?php

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteCommand
 *
 * Delete a command based on command id string.
 * ##### Permissions
 * Must have `manage_slash_commands`
 * permission for the team the command is in.
 */
class DeleteCommand extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/commands/{$this->commandId}";
	}


	/**
	 * @param string $commandId ID of the command to delete
	 */
	public function __construct(
		protected string $commandId,
	) {
	}
}
