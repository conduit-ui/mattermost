<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Groups;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetGroupsAssociatedToChannelsByTeam
 *
 * Retrieve the set of groups associated with the channels in the given team grouped by channel.
 *
 * #####
 * Permissions
 * Must have `manage_system` permission or can access only for current user
 *
 * __Minimum
 * server version__: 5.11
 */
class GetGroupsAssociatedToChannelsByTeam extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/groups_by_channels";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  null|int  $page  The page to select.
     * @param  null|bool  $filterAllowReference  Boolean which filters in the group entries with the `allow_reference` attribute set.
     * @param  null|bool  $paginate  Boolean to determine whether the pagination should be applied or not
     */
    public function __construct(
        protected string $teamId,
        protected ?int $page = null,
        protected ?bool $filterAllowReference = null,
        protected ?bool $paginate = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page, 'filter_allow_reference' => $this->filterAllowReference, 'paginate' => $this->paginate]);
    }
}
