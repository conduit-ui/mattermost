<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAllTeams
 *
 * For regular users only returns open teams. Users with the "manage_system" permission will return
 * teams regardless of type. The result is based on query string parameters - page and per_page.
 * #####
 * Permissions
 * Must be authenticated. "manage_system" permission is required to show all teams.
 */
class GetAllTeams extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/teams';
    }

    /**
     * @param  null|int  $page  The page to select.
     * @param  null|bool  $includeTotalCount  Appends a total count of returned teams inside the response object - ex: `{ "teams": [], "total_count" : 0 }`.
     * @param  null|bool  $excludePolicyConstrained  If set to true, teams which are part of a data retention policy will be excluded. The `sysconsole_read_compliance` permission is required to use this parameter.
     *                                               __Minimum server version__: 5.35
     */
    public function __construct(
        protected ?int $page = null,
        protected ?bool $includeTotalCount = null,
        protected ?bool $excludePolicyConstrained = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'page' => $this->page,
            'include_total_count' => $this->includeTotalCount,
            'exclude_policy_constrained' => $this->excludePolicyConstrained,
        ]);
    }
}
