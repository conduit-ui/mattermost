<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddTeamMemberFromInvite
 *
 * Using either an invite id or hash/data pair from an email invite link, add a user to a team.
 * #####
 * Permissions
 * Must be authenticated.
 */
class AddTeamMemberFromInvite extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/members/invite";
	}


	/**
	 * @param string $token Token id from the invitation
	 */
	public function __construct(
		protected string $token,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['token' => $this->token]);
	}
}
