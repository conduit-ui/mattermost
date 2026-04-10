<?php

namespace ConduitUI\Mattermost\Client\Requests\DataRetention;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelPoliciesForUser
 *
 * Gets the policies which are applied to the all of the channels to which a user belongs.
 *
 * __Minimum
 * server version__: 5.35
 *
 * ##### Permissions
 * Must be logged in as the user or have the `manage_system`
 * permission.
 *
 * ##### License
 * Requires an E20 license.
 */
class GetChannelPoliciesForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/data_retention/channel_policies";
	}


	/**
	 * @param string $userId The ID of the user. This can also be "me" which will point to the current user.
	 * @param null|int $page The page to select.
	 */
	public function __construct(
		protected string $userId,
		protected ?int $page = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['page' => $this->page]);
	}
}
