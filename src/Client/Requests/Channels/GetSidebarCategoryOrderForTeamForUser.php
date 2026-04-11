<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetSidebarCategoryOrderForTeamForUser
 *
 * Returns the order of the sidebar categories for a user on the given team as an array of
 * IDs.
 * __Minimum server version__: 5.26
 * ##### Permissions
 * Must be authenticated and have the
 * `list_team_channels` permission.
 */
class GetSidebarCategoryOrderForTeamForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/channels/categories/order";
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
