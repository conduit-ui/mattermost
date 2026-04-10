<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetAllChannels
 *
 * ##### Permissions
 * `manage_system`
 */
class GetAllChannels extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels";
	}


	/**
	 * @param null|string $notAssociatedToGroup A group id to exclude channels that are associated with that group via GroupChannel records. This can also be left blank with `not_associated_to_group=`.
	 * @param null|int $page The page to select.
	 * @param null|bool $excludeDefaultChannels Whether to exclude default channels (ex Town Square, Off-Topic) from the results.
	 * @param null|bool $includeDeleted Include channels that have been archived. This correlates to the `DeleteAt` flag being set in the database.
	 * @param null|bool $includeTotalCount Appends a total count of returned channels inside the response object - ex: `{ "channels": [], "total_count" : 0 }`.
	 * @param null|bool $excludePolicyConstrained If set to true, channels which are part of a data retention policy will be excluded. The `sysconsole_read_compliance` permission is required to use this parameter.
	 * __Minimum server version__: 5.35
	 */
	public function __construct(
		protected ?string $notAssociatedToGroup = null,
		protected ?int $page = null,
		protected ?bool $excludeDefaultChannels = null,
		protected ?bool $includeDeleted = null,
		protected ?bool $includeTotalCount = null,
		protected ?bool $excludePolicyConstrained = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter([
			'not_associated_to_group' => $this->notAssociatedToGroup,
			'page' => $this->page,
			'exclude_default_channels' => $this->excludeDefaultChannels,
			'include_deleted' => $this->includeDeleted,
			'include_total_count' => $this->includeTotalCount,
			'exclude_policy_constrained' => $this->excludePolicyConstrained,
		]);
	}
}
