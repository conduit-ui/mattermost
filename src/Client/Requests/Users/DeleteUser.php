<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteUser
 *
 * Deactivates the user and revokes all its sessions by archiving its user object.
 *
 * As of server
 * version 5.28, optionally use the `permanent=true` query parameter to permanently delete the user for
 * compliance reasons. To use this feature `ServiceSettings.EnableAPIUserDeletion` must be set to
 * `true` in the server's configuration.
 * ##### Permissions
 * Must be logged in as the user being
 * deactivated or have the `edit_other_users` permission.
 */
class DeleteUser extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
