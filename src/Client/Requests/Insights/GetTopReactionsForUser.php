<?php

namespace ConduitUI\Mattermost\Client\Requests\Insights;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTopReactionsForUser
 *
 * Get a list of the top reactions across all public and private channels (the user is a member of) for
 * a given user.
 * If no `team_id` is provided, this will also include reactions posted by the given user
 * in direct and group messages.
 * ##### Permissions
 * Must be logged in as the user.
 */
class GetTopReactionsForUser extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/me/top/reactions";
	}


	/**
	 * @param string $timeRange Time range can be "today", "7_day", or "28_day".
	 * - `today`: reactions posted on the current day.
	 * - `7_day`: reactions posted in the last 7 days.
	 * - `28_day`: reactions posted in the last 28 days.
	 * @param null|int $page The page to select.
	 * @param null|string $teamId Team ID will scope the response to a given team and exclude direct and group messages.
	 * ##### Permissions
	 * Must have `view_team` permission for the team.
	 */
	public function __construct(
		protected string $timeRange,
		protected ?int $page = null,
		protected ?string $teamId = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['time_range' => $this->timeRange, 'page' => $this->page, 'team_id' => $this->teamId]);
	}
}
