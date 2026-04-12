<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserAccessTokensForUser
 *
 * Get a list of user access tokens for a user. Does not include the actual authentication tokens. Use
 * query parameters for paging.
 *
 * __Minimum server version__: 4.1
 *
 * ##### Permissions
 * Must have
 * `read_user_access_token` permission. For non-self requests, must also have the `edit_other_users`
 * permission.
 */
class GetUserAccessTokensForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/tokens";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  null|int  $page  The page to select.
     */
    public function __construct(
        protected string $userId,
        protected ?int $page = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page]);
    }
}
