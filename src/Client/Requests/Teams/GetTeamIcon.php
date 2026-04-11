<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamIcon
 *
 * Get the team icon of the team.
 *
 * __Minimum server version__: 4.9
 *
 * ##### Permissions
 * User must be
 * authenticated. In addition, team must be open or the user must have the `view_team` permission.
 */
class GetTeamIcon extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/image";
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $teamId,
    ) {}
}
