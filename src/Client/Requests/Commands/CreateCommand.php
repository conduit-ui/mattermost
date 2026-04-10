<?php

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateCommand
 *
 * Create a command for a team.
 * ##### Permissions
 * `manage_slash_commands` for the team the command is
 * in.
 */
class CreateCommand extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/commands";
	}


	public function __construct()
	{
	}
}
