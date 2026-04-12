<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamByName
 *
 * Get a team based on provided name string
 * ##### Permissions
 * Must be authenticated, team type is open
 * and have the `view_team` permission.
 */
class GetTeamByName extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/name/{$this->name}";
    }

    /**
     * @param  string  $name  Team Name
     */
    public function __construct(
        protected string $name,
    ) {}
}
