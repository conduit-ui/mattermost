<?php

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ChannelMembersMinusGroupMembers
 *
 * Get the set of users who are members of the channel minus the set of users who are members of the
 * given groups.
 * Each user object contains an array of group objects representing the group memberships
 * for that user.
 * Each user object contains the boolean fields `scheme_guest`, `scheme_user`, and
 * `scheme_admin` representing the roles that user has for the given channel.
 *
 * ##### Permissions
 * Must
 * have `manage_system` permission.
 *
 * __Minimum server version__: 5.14
 */
class ChannelMembersMinusGroupMembers extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/channels/{$this->channelId}/members_minus_group_members";
	}


	/**
	 * @param string $channelId Channel GUID
	 * @param string $groupIds A comma-separated list of group ids.
	 * @param null|int $page The page to select.
	 */
	public function __construct(
		protected string $channelId,
		protected string $groupIds,
		protected ?int $page = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['group_ids' => $this->groupIds, 'page' => $this->page]);
	}
}
