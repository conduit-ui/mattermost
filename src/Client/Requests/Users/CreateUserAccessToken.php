<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateUserAccessToken
 *
 * Generate a user access token that can be used to authenticate with the Mattermost REST
 * API.
 *
 * __Minimum server version__: 4.1
 *
 * ##### Permissions
 * Must have `create_user_access_token`
 * permission. For non-self requests, must also have the `edit_other_users` permission.
 */
class CreateUserAccessToken extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/tokens";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
