<?php

namespace ConduitUI\Mattermost\Client\Requests\Preferences;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdatePreferences
 *
 * Save a list of the user's preferences.
 * ##### Permissions
 * Must be logged in as the user being updated
 * or have the `edit_other_users` permission.
 */
class UpdatePreferences extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/preferences";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
