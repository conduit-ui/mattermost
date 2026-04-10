<?php

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * InvalidateEmailInvites
 *
 * Invalidate active email invitations that have not been accepted by the user.
 * ##### Permissions
 * Must
 * have `sysconsole_write_authentication` permission.
 */
class InvalidateEmailInvites extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/invites/email";
	}


	public function __construct()
	{
	}
}
