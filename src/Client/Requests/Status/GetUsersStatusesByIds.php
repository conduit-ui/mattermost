<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Status;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetUsersStatusesByIds
 *
 * Get a list of user statuses by id from the server.
 * ##### Permissions
 * Must be authenticated.
 */
class GetUsersStatusesByIds extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/status/ids';
    }

    public function __construct() {}
}
