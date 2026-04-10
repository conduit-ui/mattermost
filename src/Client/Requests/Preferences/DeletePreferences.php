<?php

namespace ConduitUI\Mattermost\Client\Requests\Preferences;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * DeletePreferences
 *
 * Delete a list of the user's preferences.
 * ##### Permissions
 * Must be logged in as the user being
 * updated or have the `edit_other_users` permission.
 */
class DeletePreferences extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/preferences/delete";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
