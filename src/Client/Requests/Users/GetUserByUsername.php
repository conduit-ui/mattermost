<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserByUsername
 *
 * Get a user object by providing a username. Sensitive information will be sanitized out.
 * #####
 * Permissions
 * Requires an active session but no other permissions.
 */
class GetUserByUsername extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/username/{$this->username}";
    }

    /**
     * @param  string  $username  Username
     */
    public function __construct(
        protected string $username,
    ) {}
}
