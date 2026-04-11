<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetFileInfosForPost
 *
 * Gets a list of file information objects for the files attached to a post.
 * ##### Permissions
 * Must
 * have `read_channel` permission for the channel the post is in.
 */
class GetFileInfosForPost extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/posts/{$this->postId}/files/info";
    }

    /**
     * @param  string  $postId  ID of the post
     * @param  null|bool  $includeDeleted  Defines if result should include deleted posts, must have 'manage_system' (admin) permission.
     */
    public function __construct(
        protected string $postId,
        protected ?bool $includeDeleted = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['include_deleted' => $this->includeDeleted]);
    }
}
