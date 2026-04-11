<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Insights;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTopThreadsForUser
 *
 * Get a list of the top threads from public and private channels (the user is a member of and
 * participating in the thread) for a given user.
 * ##### Permissions
 * Must be logged in as the user.
 */
class GetTopThreadsForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/me/top/threads';
    }

    /**
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: threads with activity on the current day.
     *                             - `7_day`: threads with activity in the last 7 days.
     *                             - `28_day`: threads with activity in the last 28 days.
     * @param  null|int  $page  The page to select.
     * @param  null|string  $teamId  Team ID will scope the response to a given team.
     *                               ##### Permissions
     *                               Must have `view_team` permission for the team.
     */
    public function __construct(
        protected string $timeRange,
        protected ?int $page = null,
        protected ?string $teamId = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['time_range' => $this->timeRange, 'page' => $this->page, 'team_id' => $this->teamId]);
    }
}
