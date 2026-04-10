<?php

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetBot
 *
 * Get a bot specified by its bot id.
 * ##### Permissions
 * Must have `read_bots` permission for bots you
 * are managing, and `read_others_bots` permission for bots others are managing.
 * __Minimum server
 * version__: 5.10
 */
class GetBot extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/bots/{$this->botUserId}";
	}


	/**
	 * @param string $botUserId Bot user ID
	 * @param null|bool $includeDeleted If deleted bots should be returned.
	 */
	public function __construct(
		protected string $botUserId,
		protected ?bool $includeDeleted = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['include_deleted' => $this->includeDeleted]);
	}
}
