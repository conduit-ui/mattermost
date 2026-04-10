<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ViewChannel
 *
 * Perform all the actions involved in viewing a channel. This includes marking channels as read,
 * clearing push notifications, and updating the active channel.
 * ##### Permissions
 * Must be logged in as
 * user or have `edit_other_users` permission.
 *
 * __Response only includes `last_viewed_at_times` in
 * Mattermost server 4.3 and newer.__
 */
class ViewChannel extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/members/{$this->userId}/view";
	}


	/**
	 * @param string $userId User ID to perform the view action for
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
