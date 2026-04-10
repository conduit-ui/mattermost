<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserAccessToken
 *
 * Get a user access token. Does not include the actual authentication token.
 *
 * __Minimum server
 * version__: 4.1
 *
 * ##### Permissions
 * Must have `read_user_access_token` permission. For non-self
 * requests, must also have the `edit_other_users` permission.
 */
class GetUserAccessToken extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/tokens/{$this->tokenId}";
	}


	/**
	 * @param string $tokenId User access token GUID
	 */
	public function __construct(
		protected string $tokenId,
	) {
	}
}
