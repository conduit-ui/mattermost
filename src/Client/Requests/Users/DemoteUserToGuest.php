<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * DemoteUserToGuest
 *
 * Convert a regular user into a guest. This will convert the user into a
 * guest for the whole system
 * while retaining their existing team and
 * channel memberships.
 *
 * __Minimum server version__:
 * 5.16
 *
 * ##### Permissions
 * Must be logged in as the user or have the `demote_to_guest` permission.
 */
class DemoteUserToGuest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/demote";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
