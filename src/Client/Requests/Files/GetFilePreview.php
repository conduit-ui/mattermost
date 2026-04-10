<?php

namespace ConduitUI\Mattermost\Client\Requests\Files;

use DateTime;
use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFilePreview
 *
 * Gets a file's preview.
 * ##### Permissions
 * Must have `read_channel` permission or be uploader of the
 * file.
 */
class GetFilePreview extends Request
{
	protected Method $method = Method::GET;


	public function resolveEndpoint(): string
	{
		return "/api/v4/files/{$this->fileId}/preview";
	}


	/**
	 * @param string $fileId The ID of the file to get
	 */
	public function __construct(
		protected string $fileId,
	) {
	}
}
