<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SetTeamIcon
 *
 * Sets the team icon for the team.
 *
 * __Minimum server version__: 4.9
 *
 * ##### Permissions
 * Must be
 * authenticated and have the `manage_team` permission.
 */
class SetTeamIcon extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

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
