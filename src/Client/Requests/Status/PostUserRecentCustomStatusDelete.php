<?php

namespace ConduitUI\Mattermost\Client\Requests\Status;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * PostUserRecentCustomStatusDelete
 *
 * Deletes a user's recent custom status by removing the specific status from the recentCustomStatuses
 * in the user's props and updates the user.
 * ##### Permissions
 * Must be logged in as the user whose
 * recent custom status is being deleted.
 */
class PostUserRecentCustomStatusDelete extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/status/custom/recent/delete";
	}


	/**
	 * @param string $userId User ID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
