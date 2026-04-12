<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateTeamScheme
 *
 * Set a team's scheme, more specifically sets the scheme_id value of a team record.
 *
 * #####
 * Permissions
 * Must have `manage_system` permission.
 *
 * __Minimum server version__: 5.0
 */
class UpdateTeamScheme extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/scheme";
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $teamId,
    ) {}
}
