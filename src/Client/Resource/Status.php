<?php

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Status\GetUserStatus;
use ConduitUI\Mattermost\Client\Requests\Status\GetUsersStatusesByIds;
use ConduitUI\Mattermost\Client\Requests\Status\PostUserRecentCustomStatusDelete;
use ConduitUI\Mattermost\Client\Requests\Status\RemoveRecentCustomStatus;
use ConduitUI\Mattermost\Client\Requests\Status\UnsetUserCustomStatus;
use ConduitUI\Mattermost\Client\Requests\Status\UpdateUserCustomStatus;
use ConduitUI\Mattermost\Client\Requests\Status\UpdateUserStatus;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Status extends BaseResource
{
	public function getUsersStatusesByIds(): Response
	{
		return $this->connector->send(new GetUsersStatusesByIds());
	}


	/**
	 * @param string $userId User ID
	 */
	public function getUserStatus(string $userId): Response
	{
		return $this->connector->send(new GetUserStatus($userId));
	}


	/**
	 * @param string $userId User ID
	 */
	public function updateUserStatus(string $userId): Response
	{
		return $this->connector->send(new UpdateUserStatus($userId));
	}


	/**
	 * @param string $userId User ID
	 */
	public function updateUserCustomStatus(string $userId): Response
	{
		return $this->connector->send(new UpdateUserCustomStatus($userId));
	}


	/**
	 * @param string $userId User ID
	 */
	public function unsetUserCustomStatus(string $userId): Response
	{
		return $this->connector->send(new UnsetUserCustomStatus($userId));
	}


	/**
	 * @param string $userId User ID
	 */
	public function removeRecentCustomStatus(string $userId): Response
	{
		return $this->connector->send(new RemoveRecentCustomStatus($userId));
	}


	/**
	 * @param string $userId User ID
	 */
	public function postUserRecentCustomStatusDelete(string $userId): Response
	{
		return $this->connector->send(new PostUserRecentCustomStatusDelete($userId));
	}
}
