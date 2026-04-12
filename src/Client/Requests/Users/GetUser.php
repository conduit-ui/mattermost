<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUser
 *
 * Get a user a object. Sensitive information will be sanitized out.
 * ##### Permissions
 * Requires an
 * active session but no other permissions.
 */
class GetUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}";
    }

    /**
     * @param  string  $userId  User GUID. This can also be "me" which will point to the current user.
     */
    public function __construct(
        protected string $userId,
    ) {}
}
