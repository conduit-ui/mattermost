<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateSidebarCategoryForTeamForUser
 *
 * Updates a single sidebar category for the user on the given team.
 * __Minimum server version__:
 * 5.26
 * ##### Permissions
 * Must be authenticated and have the `list_team_channels` permission.
 */
class UpdateSidebarCategoryForTeamForUser extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/channels/categories/{$this->categoryId}";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $userId  User GUID
     * @param  string  $categoryId  Category GUID
     */
    public function __construct(
        protected string $teamId,
        protected string $userId,
        protected string $categoryId,
    ) {}
}
