<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * DeletePost
 *
 * Soft deletes a post, by marking the post as deleted in the database. Soft deleted posts will not be
 * returned in post queries.
 * ##### Permissions
 * Must be logged in as the user or have
 * `delete_others_posts` permission.
 */
class DeletePost extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}";
    }

    /**
     * @param  string  $postId  ID of the post to delete
     */
    public function __construct(
        protected string $postId,
    ) {}
}
