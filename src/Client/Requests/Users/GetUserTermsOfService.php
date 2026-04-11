<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserTermsOfService
 *
 * Will be deprecated in v6.0
 * Fetches user's latest terms of service action if the latest action was
 * for acceptance.
 *
 * __Minimum server version__: 5.6
 * ##### Permissions
 * Must be logged in as the user
 * being acted on.
 */
class GetUserTermsOfService extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/terms_of_service";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
