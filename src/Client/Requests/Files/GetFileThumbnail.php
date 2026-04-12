<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Files;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFileThumbnail
 *
 * Gets a file's thumbnail.
 * ##### Permissions
 * Must have `read_channel` permission or be uploader of the
 * file.
 */
class GetFileThumbnail extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/files/{$this->fileId}/thumbnail";
    }

    /**
     * @param  string  $fileId  The ID of the file to get
     */
    public function __construct(
        protected string $fileId,
    ) {}
}
