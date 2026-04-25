<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * PatchPost
 *
 * Partially update a post by providing only the fields you want to update. Omitted fields will not be
 * updated. The fields that can be updated are defined in the request body, all other provided fields
 * will be ignored.
 * ##### Permissions
 * Must have the `edit_post` permission.
 */
class PatchPost extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}/patch";
    }

    /**
     * @param  string  $postId  Post GUID
     */
    public function __construct(
        protected string $postId,
    ) {}
}
