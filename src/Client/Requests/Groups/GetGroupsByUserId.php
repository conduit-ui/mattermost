<?php

namespace ConduitUI\Mattermost\Client\Requests\Groups;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetGroupsByUserId
 *
 * Retrieve the list of groups associated to the user
 *
 * __Minimum server version__: 5.24
 */
class GetGroupsByUserId extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/groups";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
