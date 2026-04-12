<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamInviteInfo
 *
 * Get the `name`, `display_name`, `description` and `id` for a team from the invite id.
 *
 * __Minimum
 * server version__: 4.0
 *
 * ##### Permissions
 * No authentication required.
 */
class GetTeamInviteInfo extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/invite/{$this->inviteId}";
    }

    /**
     * @param  string  $inviteId  Invite id for a team
     */
    public function __construct(
        protected string $inviteId,
    ) {}
}
