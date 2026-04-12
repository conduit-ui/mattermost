<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelMembersForUser
 *
 * Get all channel memberships and associated membership roles (i.e. `channel_user`, `channel_admin`)
 * for a user on a specific team.
 * ##### Permissions
 * Logged in as the user and `view_team` permission
 * for the team. Having `manage_system` permission voids the previous requirements.
 */
class GetChannelMembersForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/channels/members";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $userId,
        protected string $teamId,
    ) {}
}
