<?php

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsAssociatedToChannelsByTeam;
use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsByChannel;
use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsByTeam;
use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsByUserId;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Groups extends BaseResource
{
	/**
	 * @param string $channelId Channel GUID
	 * @param int $page The page to select.
	 * @param bool $filterAllowReference Boolean which filters the group entries with the `allow_reference` attribute set.
	 */
	public function getGroupsByChannel(
		string $channelId,
		?int $page = null,
		?bool $filterAllowReference = null,
	): Response
	{
		return $this->connector->send(new GetGroupsByChannel($channelId, $page, $filterAllowReference));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param int $page The page to select.
	 * @param bool $filterAllowReference Boolean which filters in the group entries with the `allow_reference` attribute set.
	 */
	public function getGroupsByTeam(string $teamId, ?int $page = null, ?bool $filterAllowReference = null): Response
	{
		return $this->connector->send(new GetGroupsByTeam($teamId, $page, $filterAllowReference));
	}


	/**
	 * @param string $teamId Team GUID
	 * @param int $page The page to select.
	 * @param bool $filterAllowReference Boolean which filters in the group entries with the `allow_reference` attribute set.
	 * @param bool $paginate Boolean to determine whether the pagination should be applied or not
	 */
	public function getGroupsAssociatedToChannelsByTeam(
		string $teamId,
		?int $page = null,
		?bool $filterAllowReference = null,
		?bool $paginate = null,
	): Response
	{
		return $this->connector->send(new GetGroupsAssociatedToChannelsByTeam($teamId, $page, $filterAllowReference, $paginate));
	}


	/**
	 * @param string $userId User GUID
	 */
	public function getGroupsByUserId(string $userId): Response
	{
		return $this->connector->send(new GetGroupsByUserId($userId));
	}
}
