<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Insights;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTopChannelsForUser
 *
 * Get a list of the top public and private channels (the user is a member of) for a given user.
 * #####
 * Permissions
 * Must be logged in as the user.
 */
class GetTopChannelsForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/me/top/channels';
    }

    /**
     * @param  string  $timeRange  Time range can be "today", "7_day", or "28_day".
     *                             - `today`: channels with posts on the current day.
     *                             - `7_day`: channels with posts in the last 7 days.
     *                             - `28_day`: channels with posts in the last 28 days.
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
