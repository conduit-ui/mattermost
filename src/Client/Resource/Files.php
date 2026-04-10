<?php

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Files\GetFile;
use ConduitUI\Mattermost\Client\Requests\Files\GetFileInfo;
use ConduitUI\Mattermost\Client\Requests\Files\GetFileLink;
use ConduitUI\Mattermost\Client\Requests\Files\GetFilePreview;
use ConduitUI\Mattermost\Client\Requests\Files\GetFilePublic;
use ConduitUI\Mattermost\Client\Requests\Files\GetFileThumbnail;
use ConduitUI\Mattermost\Client\Requests\Files\UploadFile;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Files extends BaseResource
{
	/**
	 * @param string $channelId The ID of the channel that this file will be uploaded to
	 * @param string $filename The name of the file to be uploaded
	 */
	public function uploadFile(?string $channelId = null, ?string $filename = null): Response
	{
		return $this->connector->send(new UploadFile($channelId, $filename));
	}


	/**
	 * @param string $fileId The ID of the file to get
	 */
	public function getFile(string $fileId): Response
	{
		return $this->connector->send(new GetFile($fileId));
	}


	/**
	 * @param string $fileId The ID of the file info to get
	 */
	public function getFileInfo(string $fileId): Response
	{
		return $this->connector->send(new GetFileInfo($fileId));
	}


	/**
	 * @param string $fileId The ID of the file to get a link for
	 */
	public function getFileLink(string $fileId): Response
	{
		return $this->connector->send(new GetFileLink($fileId));
	}


	/**
	 * @param string $fileId The ID of the file to get
	 */
	public function getFilePreview(string $fileId): Response
	{
		return $this->connector->send(new GetFilePreview($fileId));
	}


	/**
	 * @param string $fileId The ID of the file to get
	 * @param string $h File hash
	 */
	public function getFilePublic(string $fileId, string $h): Response
	{
		return $this->connector->send(new GetFilePublic($fileId, $h));
	}


	/**
	 * @param string $fileId The ID of the file to get
	 */
	public function getFileThumbnail(string $fileId): Response
	{
		return $this->connector->send(new GetFileThumbnail($fileId));
	}
}
