<?php

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetBots
 *
 * Get a page of a list of bots.
 * ##### Permissions
 * Must have `read_bots` permission for bots you are
 * managing, and `read_others_bots` permission for bots others are managing.
 * __Minimum server
 * version__: 5.10
 */
class GetBots extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/bots";
	}


	/**
	 * @param null|int $page The page to select.
	 * @param null|bool $includeDeleted If deleted bots should be returned.
	 * @param null|bool $onlyOrphaned When true, only orphaned bots will be returned. A bot is consitered orphaned if it's owner has been deactivated.
	 */
	public function __construct(
		protected ?int $page = null,
		protected ?bool $includeDeleted = null,
		protected ?bool $onlyOrphaned = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['page' => $this->page, 'include_deleted' => $this->includeDeleted, 'only_orphaned' => $this->onlyOrphaned]);
	}
}
