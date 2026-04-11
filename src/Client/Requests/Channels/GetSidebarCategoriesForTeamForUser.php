<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSidebarCategoriesForTeamForUser
 *
 * Get a list of sidebar categories that will appear in the user's sidebar on the given team, including
 * a list of channel IDs in each category.
 * __Minimum server version__: 5.26
 * ##### Permissions
 * Must be
 * authenticated and have the `list_team_channels` permission.
 */
class GetSidebarCategoriesForTeamForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/channels/categories";
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
