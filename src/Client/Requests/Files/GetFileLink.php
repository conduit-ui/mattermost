<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Files;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFileLink
 *
 * Gets a public link for a file that can be accessed without logging into Mattermost.
 * #####
 * Permissions
 * Must have `read_channel` permission or be uploader of the file.
 */
class GetFileLink extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/files/{$this->fileId}/link";
    }

    /**
     * @param  string  $fileId  The ID of the file to get a link for
     */
    public function __construct(
        protected string $fileId,
    ) {}
}
