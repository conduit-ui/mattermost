<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * UpdatePost
 *
 * Update a post. Only the fields listed below are updatable, omitted fields will be treated as
 * blank.
 * ##### Permissions
 * Must have `edit_post` permission for the channel the post is in.
 */
class UpdatePost extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}";
    }

    /**
     * @param  string  $postId  ID of the post to update
     */
    public function __construct(
        protected string $postId,
    ) {}
}
