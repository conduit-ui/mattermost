<?php

namespace ConduitUI\Mattermost\Client\Requests\Insights;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetNewTeamMembers
 *
 * Get a list of all of the new team members that have joined the given team during the given time
 * period.
 * ##### Permissions
 * Must have `view_team` permission for the team.
 */
class GetNewTeamMembers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/teams/{$this->teamId}/top/team_members";
	}


	/**
	 * @param string $teamId Team GUID
	 * @param string $timeRange Time range can be "today", "7_day", or "28_day".
	 * - `today`: team members who joined during the current day.
	 * - `7_day`: team members who joined in the last 7 days.
	 * - `28_day`: team members who joined in the last 28 days.
	 * @param null|int $page The page to select.
	 */
	public function __construct(
		protected string $teamId,
		protected string $timeRange,
		protected ?int $page = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['time_range' => $this->timeRange, 'page' => $this->page]);
	}
}
