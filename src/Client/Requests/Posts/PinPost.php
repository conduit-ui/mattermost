<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * PinPost
 *
 * Pin a post to a channel it is in based from the provided post id string.
 * ##### Permissions
 * Must be
 * authenticated and have the `read_channel` permission to the channel the post is in.
 */
class PinPost extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}/pin";
    }

    /**
     * @param  string  $postId  Post GUID
     */
    public function __construct(
        protected string $postId,
    ) {}
}
