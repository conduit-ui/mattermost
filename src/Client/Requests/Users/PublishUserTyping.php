<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * PublishUserTyping
 *
 * Notify users in the given channel via websocket that the given user is typing.
 * __Minimum server
 * version__: 5.26
 * ##### Permissions
 * Must have `manage_system` permission to publish for any user other
 * than oneself.
 */
class PublishUserTyping extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/{$this->userId}/typing";
	}


	/**
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $userId,
	) {
	}
}
