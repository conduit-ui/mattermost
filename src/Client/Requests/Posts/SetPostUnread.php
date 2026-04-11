<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SetPostUnread
 *
 * Mark a channel as being unread from a given post.
 * ##### Permissions
 * Must have `read_channel`
 * permission for the channel the post is in or if the channel is public, have the
 * `read_public_channels` permission for the team.
 * Must have `edit_other_users` permission if the user
 * is not the one marking the post for himself.
 *
 * __Minimum server version__: 5.18
 */
class SetPostUnread extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/posts/{$this->postId}/set_unread";
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
