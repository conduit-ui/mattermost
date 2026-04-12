<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SendVerificationEmail
 *
 * Send an email with a verification link to a user that has an email matching the one in the request
 * body. This endpoint will return success even if the email does not match any users on the
 * system.
 * ##### Permissions
 * No permissions required.
 */
class SendVerificationEmail extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/email/verify/send';
    }

    public function __construct() {}
}
