<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RegisterTermsOfServiceAction
 *
 * Records user action when they accept or decline custom terms of service. Records the action in audit
 * table.
 * Updates user's last accepted terms of service ID if they accepted it.
 *
 * __Minimum server
 * version__: 5.4
 * ##### Permissions
 * Must be logged in as the user being acted on.
 */
class RegisterTermsOfServiceAction extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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
