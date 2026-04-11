<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateTeam
 *
 * Update a team by providing the team object. The fields that can be updated are defined in the
 * request body, all other provided fields will be ignored.
 * ##### Permissions
 * Must have the
 * `manage_team` permission.
 */
class UpdateTeam extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}";
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $teamId,
    ) {}
}
