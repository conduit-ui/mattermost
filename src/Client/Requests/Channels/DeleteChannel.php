<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeleteChannel
 *
 * Archives a channel. This will set the `deleteAt` to the current timestamp in the database. Soft
 * deleted channels may not be accessible in the user interface. They can be viewed and unarchived in
 * the **System Console > User Management > Channels** based on your license. Direct and group message
 * channels cannot be deleted.
 *
 * As of server version 5.28, optionally use the `permanent=true` query
 * parameter to permanently delete the channel for compliance reasons. To use this feature
 * `ServiceSettings.EnableAPIChannelDeletion` must be set to `true` in the server's configuration.  If
 * you permanently delete a channel this action is not recoverable outside of a database backup.
 *
 * #####
 * Permissions
 * `delete_public_channel` permission if the channel is public,
 * `delete_private_channel`
 * permission if the channel is private,
 * or have `manage_system` permission.
 */
class DeleteChannel extends Request
{
	protected Method $method = Method::DELETE;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}";
	}


	/**
	 * @param string $channelId Channel GUID
	 */
	public function __construct(
		protected string $channelId,
	) {
	}
}
