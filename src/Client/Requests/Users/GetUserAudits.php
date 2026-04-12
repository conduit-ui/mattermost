<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserAudits
 *
 * Get a list of audit by providing the user GUID.
 * ##### Permissions
 * Must be logged in as the user or
 * have the `edit_other_users` permission.
 */
class GetUserAudits extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/audits";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
