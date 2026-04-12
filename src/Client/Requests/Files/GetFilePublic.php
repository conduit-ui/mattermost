<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Files;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFilePublic
 *
 * ##### Permissions
 * No permissions required.
 */
class GetFilePublic extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/files/{$this->fileId}/public";
    }

    /**
     * @param  string  $fileId  The ID of the file to get
     * @param  string  $h  File hash
     */
    public function __construct(
        protected string $fileId,
        protected string $h,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['h' => $this->h]);
    }
}
