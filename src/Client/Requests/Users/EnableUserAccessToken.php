<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * EnableUserAccessToken
 *
 * Re-enable a personal access token that has been disabled.
 *
 * __Minimum server version__: 4.4
 *
 * #####
 * Permissions
 * Must have `create_user_access_token` permission. For non-self requests, must also have
 * the `edit_other_users` permission.
 */
class EnableUserAccessToken extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/tokens/enable";
	}


	public function __construct()
	{
	}
}
