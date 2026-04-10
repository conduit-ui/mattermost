<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetUsersByGroupChannelIds
 *
 * Get an object containing a key per group channel id in the
 * query and its value as a list of users
 * members of that group
 * channel.
 *
 * The user must be a member of the group ids in the query, or
 * they
 * will be omitted from the response.
 * ##### Permissions
 * Requires an active session but no other
 * permissions.
 *
 * __Minimum server version__: 5.14
 */
class GetUsersByGroupChannelIds extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/group_channels";
	}


	public function __construct()
	{
	}
}
