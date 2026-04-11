<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Groups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetGroupsByTeam
 *
 * Retrieve the list of groups associated with a given team.
 *
 * __Minimum server version__: 5.11
 */
class GetGroupsByTeam extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/groups";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  null|int  $page  The page to select.
     * @param  null|bool  $filterAllowReference  Boolean which filters in the group entries with the `allow_reference` attribute set.
     */
    public function __construct(
        protected string $teamId,
        protected ?int $page = null,
        protected ?bool $filterAllowReference = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'filter_allow_reference' => $this->filterAllowReference]);
    }
}
