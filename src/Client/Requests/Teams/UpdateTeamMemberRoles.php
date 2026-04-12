<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateTeamMemberRoles
 *
 * Update a team member roles. Valid team roles are "team_user", "team_admin" or both of them.
 * Overwrites any previously assigned team roles.
 * ##### Permissions
 * Must be authenticated and have the
 * `manage_team_roles` permission.
 */
class UpdateTeamMemberRoles extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/members/{$this->userId}/roles";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $teamId,
        protected string $userId,
    ) {}
}
