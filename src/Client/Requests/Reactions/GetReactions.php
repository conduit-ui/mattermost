<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Reactions;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetReactions
 *
 * Get a list of reactions made by all users to a given post.
 * ##### Permissions
 * Must have
 * `read_channel` permission for the channel the post is in.
 */
class GetReactions extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}/reactions";
    }

    /**
     * @param  string  $postId  ID of a post
     */
    public function __construct(
        protected string $postId,
    ) {}
}
