<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PatchUser
 *
 * Partially update a user by providing only the fields you want to update. Omitted fields will not be
 * updated. The fields that can be updated are defined in the request body, all other provided fields
 * will be ignored.
 * ##### Permissions
 * Must be logged in as the user being updated or have the
 * `edit_other_users` permission.
 */
class PatchUser extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/patch";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
