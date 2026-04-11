<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Insights\GetNewTeamMembers;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopChannelsForTeam;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopChannelsForUser;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopDmsForUser;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopReactionsForTeam;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopReactionsForUser;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopThreadsForTeam;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopThreadsForUser;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Insights extends BaseResource
{
    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: channels with posts on the current day.
     *                             - `7_day`: channels with posts in the last 7 days.
     *                             - `28_day`: channels with posts in the last 28 days.
     * @param  int  $page  The page to select.
     */
    public function getTopChannelsForTeam(string $teamId, string $timeRange, ?int $page = null): Response
    {
        return $this->connector->send(new GetTopChannelsForTeam($teamId, $timeRange, $page));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: reactions posted on the current day.
     *                             - `7_day`: reactions posted in the last 7 days.
     *                             - `28_day`: reactions posted in the last 28 days.
     * @param  int  $page  The page to select.
     */
    public function getTopReactionsForTeam(string $teamId, string $timeRange, ?int $page = null): Response
    {
        return $this->connector->send(new GetTopReactionsForTeam($teamId, $timeRange, $page));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: team members who joined during the current day.
     *                             - `7_day`: team members who joined in the last 7 days.
     *                             - `28_day`: team members who joined in the last 28 days.
     * @param  int  $page  The page to select.
     */
    public function getNewTeamMembers(string $teamId, string $timeRange, ?int $page = null): Response
    {
        return $this->connector->send(new GetNewTeamMembers($teamId, $timeRange, $page));
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: threads with activity on the current day.
     *                             - `7_day`: threads with activity in the last 7 days.
     *                             - `28_day`: threads with activity in the last 28 days.
     * @param  int  $page  The page to select.
     */
    public function getTopThreadsForTeam(string $teamId, string $timeRange, ?int $page = null): Response
    {
        return $this->connector->send(new GetTopThreadsForTeam($teamId, $timeRange, $page));
    }

    /**
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: channels with posts on the current day.
     *                             - `7_day`: channels with posts in the last 7 days.
     *                             - `28_day`: channels with posts in the last 28 days.
     * @param  int  $page  The page to select.
     * @param  string  $teamId  Team ID will scope the response to a given team.
     *                          ##### Permissions
     *                          Must have `view_team` permission for the team.
     */
    public function getTopChannelsForUser(string $timeRange, ?int $page = null, ?string $teamId = null): Response
    {
        return $this->connector->send(new GetTopChannelsForUser($timeRange, $page, $teamId));
    }

    /**
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: threads with activity on the current day.
     *                             - `7_day`: threads with activity in the last 7 days.
     *                             - `28_day`: threads with activity in the last 28 days.
     * @param  int  $page  The page to select.
     */
    public function getTopDmsForUser(string $timeRange, ?int $page = null): Response
    {
        return $this->connector->send(new GetTopDmsForUser($timeRange, $page));
    }

    /**
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: reactions posted on the current day.
     *                             - `7_day`: reactions posted in the last 7 days.
     *                             - `28_day`: reactions posted in the last 28 days.
     * @param  int  $page  The page to select.
     * @param  string  $teamId  Team ID will scope the response to a given team and exclude direct and group messages.
     *                          ##### Permissions
     *                          Must have `view_team` permission for the team.
     */
    public function getTopReactionsForUser(string $timeRange, ?int $page = null, ?string $teamId = null): Response
    {
        return $this->connector->send(new GetTopReactionsForUser($timeRange, $page, $teamId));
    }

    /**
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: threads with activity on the current day.
     *                             - `7_day`: threads with activity in the last 7 days.
     *                             - `28_day`: threads with activity in the last 28 days.
     * @param  int  $page  The page to select.
     * @param  string  $teamId  Team ID will scope the response to a given team.
     *                          ##### Permissions
     *                          Must have `view_team` permission for the team.
     */
    public function getTopThreadsForUser(string $timeRange, ?int $page = null, ?string $teamId = null): Response
    {
        return $this->connector->send(new GetTopThreadsForUser($timeRange, $page, $teamId));
    }
}
