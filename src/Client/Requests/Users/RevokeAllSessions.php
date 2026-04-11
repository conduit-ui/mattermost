<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RevokeAllSessions
 *
 * Revokes all user sessions from the provided user id and session id strings.
 * ##### Permissions
 * Must
 * be logged in as the user being updated or have the `edit_other_users` permission.
 * __Minimum server
 * version__: 4.4
 */
class RevokeAllSessions extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/sessions/revoke/all";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
