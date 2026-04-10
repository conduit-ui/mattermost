<?php

namespace ConduitUI\Mattermost\Client\Requests\Threads;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserThreads
 *
 * Get all threads that user is following
 *
 * __Minimum server version__: 5.29
 *
 * ##### Permissions
 * Must be
 * logged in as the user or have `edit_other_users` permission.
 */
class GetUserThreads extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/threads";
	}


	/**
	 * @param string $userId The ID of the user. This can also be "me" which will point to the current user.
	 * @param string $teamId The ID of the team in which the thread is.
	 * @param null|int $since Since filters the threads based on their LastUpdateAt timestamp.
	 * @param null|bool $deleted Deleted will specify that even deleted threads should be returned (For mobile sync).
	 * @param null|bool $extended Extended will enrich the response with participant details.
	 * @param null|int $page Page specifies which part of the results to return, by PageSize.
	 * @param null|int $pageSize PageSize specifies the size of the returned chunk of results.
	 * @param null|bool $totalsOnly Setting this to true will only return the total counts.
	 * @param null|bool $threadsOnly Setting this to true will only return threads.
	 */
	public function __construct(
		protected string $userId,
		protected string $teamId,
		protected ?int $since = null,
		protected ?bool $deleted = null,
		protected ?bool $extended = null,
		protected ?int $page = null,
		protected ?int $pageSize = null,
		protected ?bool $totalsOnly = null,
		protected ?bool $threadsOnly = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'since' => $this->since,
			'deleted' => $this->deleted,
			'extended' => $this->extended,
			'page' => $this->page,
			'pageSize' => $this->pageSize,
			'totalsOnly' => $this->totalsOnly,
			'threadsOnly' => $this->threadsOnly,
		]);
	}
}
