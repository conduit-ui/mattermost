<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Threads;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * SetThreadUnreadByPostId
 *
 * Mark a thread that user is following as unread
 *
 * __Minimum server version__: 6.7
 *
 * #####
 * Permissions
 * Must have `read_channel` permission for the channel the thread is in or if the channel
 * is public, have the `read_public_channels` permission for the team.
 *
 * Must have `edit_other_users`
 * permission if the user is not the one marking the thread for himself.
 */
class SetThreadUnreadByPostId extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/teams/{$this->teamId}/threads/{$this->threadId}/set_unread/{$this->postId}";
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  string  $threadId  The ID of the thread to update
     * @param  string  $postId  The ID of a post belonging to the thread to mark as unread.
     */
    public function __construct(
        protected string $userId,
        protected string $teamId,
        protected string $threadId,
        protected string $postId,
    ) {}
}
