<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * SaveAcknowledgementForPost
 *
 * Delete an acknowledgement form a post that you had previously acknowledged.
 * ##### Permissions
 * Must
 * have `read_channel` permission for the channel the post is in.<br/> Must be logged in as the user or
 * have `edit_other_users` permission.<br/> The post must have been acknowledged in the previous 5
 * minutes.
 *
 * __Minimum server version__: 7.7
 */
class SaveAcknowledgementForPost extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/posts/{$this->postId}/ack";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $postId  Post GUID
     */
    public function __construct(
        protected string $userId,
        protected string $postId,
    ) {}
}
