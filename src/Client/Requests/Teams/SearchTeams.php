<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchTeams
 *
 * Search teams based on search term and options provided in the request body.
 *
 * #####
 * Permissions
 * Logged in user only shows open teams
 * Logged in user with "manage_system" permission
 * shows all teams
 */
class SearchTeams extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/search";
	}


	public function __construct()
	{
	}
}
