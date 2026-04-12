<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateTeamPrivacy
 *
 * Updates team's privacy allowing changing a team from Public (open) to Private (invitation only) and
 * back.
 *
 * __Minimum server version__: 5.24
 *
 * ##### Permissions
 * `manage_team` permission for the team of
 * the team.
 */
class UpdateTeamPrivacy extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/privacy";
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $teamId,
    ) {}
}
