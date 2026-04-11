<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamMembers
 *
 * Get a page team members list based on query string parameters - team id, page and per page.
 * #####
 * Permissions
 * Must be authenticated and have the `view_team` permission.
 */
class GetTeamMembers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/members";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  null|int  $page  The page to select.
     */
    public function __construct(
        protected string $teamId,
        protected ?int $page = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page]);
    }
}
