<?php

namespace ConduitUI\Mattermost\Client\Requests\Files;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * UploadFile
 *
 * Uploads a file that can later be attached to a post.
 *
 * This request can either be a
 * multipart/form-data request with a channel_id, files and optional
 * client_ids defined in the
 * FormData, or it can be a request with the channel_id and filename
 * defined as query parameters with
 * the contents of a single file in the body of the request.
 *
 * Only multipart/form-data requests are
 * supported by server versions up to and including 4.7.
 * Server versions 4.8 and higher support both
 * types of requests.
 *
 * ##### Permissions
 * Must have `upload_file` permission.
 */
class UploadFile extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/files";
	}


	/**
	 * @param null|string $channelId The ID of the channel that this file will be uploaded to
	 * @param null|string $filename The name of the file to be uploaded
	 */
	public function __construct(
		protected ?string $channelId = null,
		protected ?string $filename = null,
	) {
	}


	public function defaultQuery(): array
	{
		return array_filter(['channel_id' => $this->channelId, 'filename' => $this->filename]);
	}
}
