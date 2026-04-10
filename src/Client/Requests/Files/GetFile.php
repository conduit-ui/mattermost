<?php

namespace ConduitUI\Mattermost\Client\Requests\Files;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFile
 *
 * Gets a file that has been uploaded previously.
 * ##### Permissions
 * Must have `read_channel` permission
 * or be uploader of the file.
 */
class GetFile extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/files/{$this->fileId}";
	}


	/**
	 * @param string $fileId The ID of the file to get
	 */
	public function __construct(
		protected string $fileId,
	) {
	}
}
