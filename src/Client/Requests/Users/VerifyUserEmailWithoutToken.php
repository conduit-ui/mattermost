<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * VerifyUserEmailWithoutToken
 *
 * Verify the email used by a user without a token.
 *
 * __Minimum server version__: 5.24
 *
 * #####
 * Permissions
 *
 * Must have `manage_system` permission.
 */
class VerifyUserEmailWithoutToken extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/email/verify/member";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
