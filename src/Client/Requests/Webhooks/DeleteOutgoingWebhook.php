<?php

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteOutgoingWebhook
 *
 * Delete an outgoing webhook given the hook id.
 * ##### Permissions
 * `manage_webhooks` for system or
 * `manage_webhooks` for the specific team or `manage_webhooks` for the channel.
 */
class DeleteOutgoingWebhook extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/hooks/outgoing/{$this->hookId}";
	}


	/**
	 * @param string $hookId Outgoing webhook GUID
	 */
	public function __construct(
		protected string $hookId,
	) {
	}
}
