<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * TeamMembersMinusGroupMembers
 *
 * Get the set of users who are members of the team minus the set of users who are members of the given
 * groups.
 * Each user object contains an array of group objects representing the group memberships for
 * that user.
 * Each user object contains the boolean fields `scheme_guest`, `scheme_user`, and
 * `scheme_admin` representing the roles that user has for the given team.
 *
 * ##### Permissions
 * Must have
 * `manage_system` permission.
 *
 * __Minimum server version__: 5.14
 */
class TeamMembersMinusGroupMembers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/members_minus_group_members";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $groupIds  A comma-separated list of group ids.
     * @param  null|int  $page  The page to select.
     */
    public function __construct(
        protected string $teamId,
        protected string $groupIds,
        protected ?int $page = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['group_ids' => $this->groupIds, 'page' => $this->page]);
    }
}
