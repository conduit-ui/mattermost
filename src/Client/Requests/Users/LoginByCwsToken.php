<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * LoginByCwsToken
 *
 * CWS stands for Customer Web Server which is the cloud service used to manage cloud instances.
 * #####
 * Permissions
 * A Cloud license is required
 */
class LoginByCwsToken extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/login/cws';
    }

    public function __construct() {}
}
