<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateChannelMemberSchemeRoles
 *
 * Update a channel member's scheme_admin/scheme_user properties. Typically this should either be
 * `scheme_admin=false, scheme_user=true` for ordinary channel member, or `scheme_admin=true,
 * scheme_user=true` for a channel admin.
 * __Minimum server version__: 5.0
 * ##### Permissions
 * Must be
 * authenticated and have the `manage_channel_roles` permission.
 */
class UpdateChannelMemberSchemeRoles extends Request
{
	protected Method $method = Method::PUT;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/members/{$this->userId}/schemeRoles";
	}


	/**
	 * @param string $channelId Channel GUID
	 * @param string $userId User GUID
	 */
	public function __construct(
		protected string $channelId,
		protected string $userId,
	) {
	}
}
