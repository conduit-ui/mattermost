<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchUsers
 *
 * Get a list of users based on search criteria provided in the request body. Searches are typically
 * done against username, full name, nickname and email unless otherwise configured by the
 * server.
 * ##### Permissions
 * Requires an active session and `read_channel` and/or `view_team`
 * permissions for any channels or teams specified in the request body.
 */
class SearchUsers extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/search';
    }

    public function __construct() {}
}
