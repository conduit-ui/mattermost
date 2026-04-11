<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetDeletedChannelsForTeam
 *
 * Get a page of deleted channels on a team based on query string parameters - team_id, page and
 * per_page.
 *
 * __Minimum server version__: 3.10
 */
class GetDeletedChannelsForTeam extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/channels/deleted";
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
