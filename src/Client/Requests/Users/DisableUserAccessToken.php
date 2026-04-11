<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * DisableUserAccessToken
 *
 * Disable a personal access token and delete any sessions using the token. The token can be re-enabled
 * using `/users/tokens/enable`.
 *
 * __Minimum server version__: 4.4
 *
 * ##### Permissions
 * Must have
 * `revoke_user_access_token` permission. For non-self requests, must also have the `edit_other_users`
 * permission.
 */
class DisableUserAccessToken extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/tokens/disable';
    }

    public function __construct() {}
}
