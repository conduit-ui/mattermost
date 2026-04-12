<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RevokeSessionsFromAllUsers
 *
 * For any session currently on the server (including admin) it will be revoked.
 * Clients will be
 * notified to log out users.
 *
 * __Minimum server version__: 5.14
 *
 * ##### Permissions
 * Must have
 * `manage_system` permission.
 */
class RevokeSessionsFromAllUsers extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/sessions/revoke/all';
    }

    public function __construct() {}
}
