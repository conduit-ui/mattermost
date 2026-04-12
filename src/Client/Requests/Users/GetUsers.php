<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUsers
 *
 * Get a page of a list of users. Based on query string parameters, select users from a team, channel,
 * or select users not in a specific channel.
 *
 * Since server version 4.0, some basic sorting is
 * available using the `sort` query parameter. Sorting is currently only supported when selecting users
 * on a team.
 * ##### Permissions
 * Requires an active session and (if specified) membership to the channel
 * or team being selected from.
 */
class GetUsers extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users';
    }

    /**
     * @param  null|int  $page  The page to select.
     * @param  null|string  $inTeam  The ID of the team to get users for.
     * @param  null|string  $notInTeam  The ID of the team to exclude users for. Must not be used with "in_team" query parameter.
     * @param  null|string  $inChannel  The ID of the channel to get users for.
     * @param  null|string  $notInChannel  The ID of the channel to exclude users for. Must be used with "in_channel" query parameter.
     * @param  null|string  $inGroup  The ID of the group to get users for. Must have `manage_system` permission.
     * @param  null|bool  $groupConstrained  When used with `not_in_channel` or `not_in_team`, returns only the users that are allowed to join the channel or team based on its group constrains.
     * @param  null|bool  $withoutTeam  Whether or not to list users that are not on any team. This option takes precendence over `in_team`, `in_channel`, and `not_in_channel`.
     * @param  null|bool  $active  Whether or not to list only users that are active. This option cannot be used along with the `inactive` option.
     * @param  null|bool  $inactive  Whether or not to list only users that are deactivated. This option cannot be used along with the `active` option.
     * @param  null|string  $role  Returns users that have this role.
     * @param  null|string  $sort  Sort is only available in conjunction with certain options below. The paging parameter is also always available.
     *
     * ##### `in_team`
     * Can be "", "last_activity_at" or "create_at".
     * When left blank, sorting is done by username.
     * __Minimum server version__: 4.0
     * ##### `in_channel`
     * Can be "", "status".
     * When left blank, sorting is done by username. `status` will sort by User's current status (Online, Away, DND, Offline), then by Username.
     * __Minimum server version__: 4.7
     * ##### `in_group`
     * Can be "", "display_name".
     * When left blank, sorting is done by username. `display_name` will sort alphabetically by user's display name.
     * __Minimum server version__: 7.7
     * @param  null|string  $roles  Comma separated string used to filter users based on any of the specified system roles
     *
     * Example: `?roles=system_admin,system_user` will return users that are either system admins or system users
     *
     * __Minimum server version__: 5.26
     * @param  null|string  $channelRoles  Comma separated string used to filter users based on any of the specified channel roles, can only be used in conjunction with `in_channel`
     *
     * Example: `?in_channel=4eb6axxw7fg3je5iyasnfudc5y&channel_roles=channel_user` will return users that are only channel users and not admins or guests
     *
     * __Minimum server version__: 5.26
     * @param  null|string  $teamRoles  Comma separated string used to filter users based on any of the specified team roles, can only be used in conjunction with `in_team`
     *
     * Example: `?in_team=4eb6axxw7fg3je5iyasnfudc5y&team_roles=team_user` will return users that are only team users and not admins or guests
     *
     * __Minimum server version__: 5.26
     */
    public function __construct(
        protected ?int $page = null,
        protected ?string $inTeam = null,
        protected ?string $notInTeam = null,
        protected ?string $inChannel = null,
        protected ?string $notInChannel = null,
        protected ?string $inGroup = null,
        protected ?bool $groupConstrained = null,
        protected ?bool $withoutTeam = null,
        protected ?bool $active = null,
        protected ?bool $inactive = null,
        protected ?string $role = null,
        protected ?string $sort = null,
        protected ?string $roles = null,
        protected ?string $channelRoles = null,
        protected ?string $teamRoles = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'page' => $this->page,
            'in_team' => $this->inTeam,
            'not_in_team' => $this->notInTeam,
            'in_channel' => $this->inChannel,
            'not_in_channel' => $this->notInChannel,
            'in_group' => $this->inGroup,
            'group_constrained' => $this->groupConstrained,
            'without_team' => $this->withoutTeam,
            'active' => $this->active,
            'inactive' => $this->inactive,
            'role' => $this->role,
            'sort' => $this->sort,
            'roles' => $this->roles,
            'channel_roles' => $this->channelRoles,
            'team_roles' => $this->teamRoles,
        ]);
    }
}
