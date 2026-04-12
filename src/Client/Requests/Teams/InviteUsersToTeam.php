<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * InviteUsersToTeam
 *
 * Invite users to the existing team using the user's email.
 *
 * The number of emails that can be sent is
 * rate limited to 20 per hour with a burst of 20 emails. If the rate limit exceeds, the error message
 * contains details on when to retry and when the timer will be reset.
 * ##### Permissions
 * Must have
 * `invite_user` and `add_user_to_team` permissions for the team.
 */
class InviteUsersToTeam extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/invite/email";
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $teamId,
    ) {}
}
