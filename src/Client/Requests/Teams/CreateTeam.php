<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateTeam
 *
 * Create a new team on the system.
 * ##### Permissions
 * Must be authenticated and have the `create_team`
 * permission.
 */
class CreateTeam extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/teams';
    }

    public function __construct() {}
}
