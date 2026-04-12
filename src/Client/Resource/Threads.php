<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Threads\GetThreadMentionCountsByChannel;
use ConduitUI\Mattermost\Client\Requests\Threads\GetUserThread;
use ConduitUI\Mattermost\Client\Requests\Threads\GetUserThreads;
use ConduitUI\Mattermost\Client\Requests\Threads\SetThreadUnreadByPostId;
use ConduitUI\Mattermost\Client\Requests\Threads\StartFollowingThread;
use ConduitUI\Mattermost\Client\Requests\Threads\StopFollowingThread;
use ConduitUI\Mattermost\Client\Requests\Threads\UpdateThreadReadForUser;
use ConduitUI\Mattermost\Client\Requests\Threads\UpdateThreadsReadForUser;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Threads extends BaseResource
{
    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  int  $since  Since filters the threads based on their LastUpdateAt timestamp.
     * @param  bool  $deleted  Deleted will specify that even deleted threads should be returned (For mobile sync).
     * @param  bool  $extended  Extended will enrich the response with participant details.
     * @param  int  $page  Page specifies which part of the results to return, by PageSize.
     * @param  int  $pageSize  PageSize specifies the size of the returned chunk of results.
     * @param  bool  $totalsOnly  Setting this to true will only return the total counts.
     * @param  bool  $threadsOnly  Setting this to true will only return threads.
     */
    public function getUserThreads(
        string $userId,
        string $teamId,
        ?int $since = null,
        ?bool $deleted = null,
        ?bool $extended = null,
        ?int $page = null,
        ?int $pageSize = null,
        ?bool $totalsOnly = null,
        ?bool $threadsOnly = null,
    ): Response {
        return $this->connector->send(new GetUserThreads($userId, $teamId, $since, $deleted, $extended, $page, $pageSize, $totalsOnly, $threadsOnly));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     */
    public function getThreadMentionCountsByChannel(string $userId, string $teamId): Response
    {
        return $this->connector->send(new GetThreadMentionCountsByChannel($userId, $teamId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     */
    public function updateThreadsReadForUser(string $userId, string $teamId): Response
    {
        return $this->connector->send(new UpdateThreadsReadForUser($userId, $teamId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  string  $threadId  The ID of the thread to follow
     */
    public function getUserThread(string $userId, string $teamId, string $threadId): Response
    {
        return $this->connector->send(new GetUserThread($userId, $teamId, $threadId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  string  $threadId  The ID of the thread to follow
     */
    public function startFollowingThread(string $userId, string $teamId, string $threadId): Response
    {
        return $this->connector->send(new StartFollowingThread($userId, $teamId, $threadId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  string  $threadId  The ID of the thread to update
     */
    public function stopFollowingThread(string $userId, string $teamId, string $threadId): Response
    {
        return $this->connector->send(new StopFollowingThread($userId, $teamId, $threadId));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  string  $threadId  The ID of the thread to update
     * @param  string  $timestamp  The timestamp to which the thread's "last read" state will be reset.
     */
    public function updateThreadReadForUser(
        string $userId,
        string $teamId,
        string $threadId,
        string $timestamp,
    ): Response {
        return $this->connector->send(new UpdateThreadReadForUser($userId, $teamId, $threadId, $timestamp));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  string  $teamId  The ID of the team in which the thread is.
     * @param  string  $threadId  The ID of the thread to update
     * @param  string  $postId  The ID of a post belonging to the thread to mark as unread.
     */
    public function setThreadUnreadByPostId(string $userId, string $teamId, string $threadId, string $postId): Response
    {
        return $this->connector->send(new SetThreadUnreadByPostId($userId, $teamId, $threadId, $postId));
    }
}
