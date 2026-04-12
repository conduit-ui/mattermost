<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamsUnreadForUser
 *
 * Get the count for unread messages and mentions in the teams the user is a member of.
 * #####
 * Permissions
 * Must be logged in.
 */
class GetTeamsUnreadForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/teams/unread";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $excludeTeam  Optional team id to be excluded from the results
     * @param  null|bool  $includeCollapsedThreads  Boolean to determine whether the collapsed threads should be included or not
     */
    public function __construct(
        protected string $userId,
        protected string $excludeTeam,
        protected ?bool $includeCollapsedThreads = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['exclude_team' => $this->excludeTeam, 'include_collapsed_threads' => $this->includeCollapsedThreads]);
    }
}
