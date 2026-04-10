<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchUserAccessTokens
 *
 * Get a list of tokens based on search criteria provided in the request body. Searches are done
 * against the token id, user id and username.
 *
 * __Minimum server version__: 4.7
 *
 * ##### Permissions
 * Must
 * have `manage_system` permission.
 */
class SearchUserAccessTokens extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/tokens/search";
	}


	public function __construct()
	{
	}
}
