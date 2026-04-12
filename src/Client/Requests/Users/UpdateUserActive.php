<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserActive
 *
 * Update user active or inactive status.
 *
 * __Since server version 4.6, users using a SSO provider to
 * login can be activated or deactivated with this endpoint. However, if their activation status in
 * Mattermost does not reflect their status in the SSO provider, the next synchronization or login by
 * that user will reset the activation status to that of their account in the SSO provider. Server
 * versions 4.5 and before do not allow activation or deactivation of SSO users from this
 * endpoint.__
 * ##### Permissions
 * User can deactivate themselves.
 * User with `manage_system` permission
 * can activate or deactivate a user.
 */
class UpdateUserActive extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/active";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
