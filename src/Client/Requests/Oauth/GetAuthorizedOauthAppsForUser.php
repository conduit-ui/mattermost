<?php

namespace ConduitUI\Mattermost\Client\Requests\Oauth;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAuthorizedOAuthAppsForUser
 *
 * Get a page of OAuth 2.0 client applications authorized to access a user's account.
 * #####
 * Permissions
 * Must be authenticated as the user or have `edit_other_users` permission.
 */
class GetAuthorizedOauthAppsForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/oauth/apps/authorized";
	}


	/**
	 * @param string $userId User GUID
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
