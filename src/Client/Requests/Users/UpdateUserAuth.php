<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserAuth
 *
 * Updates a user's authentication method. This can be used to change them to/from LDAP authentication
 * for example.
 *
 * __Minimum server version__: 4.6
 * ##### Permissions
 * Must have the `edit_other_users`
 * permission.
 */
class UpdateUserAuth extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/auth";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
