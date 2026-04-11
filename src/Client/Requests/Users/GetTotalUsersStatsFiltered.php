<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTotalUsersStatsFiltered
 *
 * Get a count of users in the system matching the specified filters.
 *
 * __Minimum server version__:
 * 5.26
 *
 * ##### Permissions
 * Must have `manage_system` permission.
 */
class GetTotalUsersStatsFiltered extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/stats/filtered';
    }

    /**
     * @param  null|string  $inTeam  The ID of the team to get user stats for.
     * @param  null|string  $inChannel  The ID of the channel to get user stats for.
     * @param  null|bool  $includeDeleted  If deleted accounts should be included in the count.
     * @param  null|bool  $includeBots  If bot accounts should be included in the count.
     * @param  null|string  $roles  Comma separated string used to filter users based on any of the specified system roles
     *
     * Example: `?roles=system_admin,system_user` will include users that are either system admins or system users
     * @param  null|string  $channelRoles  Comma separated string used to filter users based on any of the specified channel roles, can only be used in conjunction with `in_channel`
     *
     * Example: `?in_channel=4eb6axxw7fg3je5iyasnfudc5y&channel_roles=channel_user` will include users that are only channel users and not admins or guests
     * @param  null|string  $teamRoles  Comma separated string used to filter users based on any of the specified team roles, can only be used in conjunction with `in_team`
     *
     * Example: `?in_team=4eb6axxw7fg3je5iyasnfudc5y&team_roles=team_user` will include users that are only team users and not admins or guests
     */
    public function __construct(
        protected ?string $inTeam = null,
        protected ?string $inChannel = null,
        protected ?bool $includeDeleted = null,
        protected ?bool $includeBots = null,
        protected ?string $roles = null,
        protected ?string $channelRoles = null,
        protected ?string $teamRoles = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter([
            'in_team' => $this->inTeam,
            'in_channel' => $this->inChannel,
            'include_deleted' => $this->includeDeleted,
            'include_bots' => $this->includeBots,
            'roles' => $this->roles,
            'channel_roles' => $this->channelRoles,
            'team_roles' => $this->teamRoles,
        ]);
    }
}
