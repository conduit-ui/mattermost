<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RevokeUserAccessToken
 *
 * Revoke a user access token and delete any sessions using the token.
 *
 * __Minimum server version__:
 * 4.1
 *
 * ##### Permissions
 * Must have `revoke_user_access_token` permission. For non-self requests, must
 * also have the `edit_other_users` permission.
 */
class RevokeUserAccessToken extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/tokens/revoke';
    }

    public function __construct() {}
}
