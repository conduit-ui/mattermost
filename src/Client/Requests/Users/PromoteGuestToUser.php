<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * PromoteGuestToUser
 *
 * Convert a guest into a regular user. This will convert the guest into a
 * user for the whole system
 * while retaining any team and channel
 * memberships and automatically joining them to the default
 * channels.
 *
 * __Minimum server version__: 5.16
 *
 * ##### Permissions
 * Must be logged in as the user or have
 * the `promote_guest` permission.
 */
class PromoteGuestToUser extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/promote";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
