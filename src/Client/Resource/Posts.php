<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePostEphemeral;
use ConduitUI\Mattermost\Client\Requests\Posts\DeletePost;
use ConduitUI\Mattermost\Client\Requests\Posts\DoPostAction;
use ConduitUI\Mattermost\Client\Requests\Posts\GetFileInfosForPost;
use ConduitUI\Mattermost\Client\Requests\Posts\GetFlaggedPostsForUser;
use ConduitUI\Mattermost\Client\Requests\Posts\GetPost;
use ConduitUI\Mattermost\Client\Requests\Posts\GetPostsAroundLastUnread;
use ConduitUI\Mattermost\Client\Requests\Posts\GetPostsByIds;
use ConduitUI\Mattermost\Client\Requests\Posts\GetPostsForChannel;
use ConduitUI\Mattermost\Client\Requests\Posts\GetPostThread;
use ConduitUI\Mattermost\Client\Requests\Posts\PatchPost;
use ConduitUI\Mattermost\Client\Requests\Posts\PinPost;
use ConduitUI\Mattermost\Client\Requests\Posts\SaveAcknowledgementForPost;
use ConduitUI\Mattermost\Client\Requests\Posts\SearchPosts;
use ConduitUI\Mattermost\Client\Requests\Posts\SetPostReminder;
use ConduitUI\Mattermost\Client\Requests\Posts\SetPostUnread;
use ConduitUI\Mattermost\Client\Requests\Posts\UnpinPost;
use ConduitUI\Mattermost\Client\Requests\Posts\UpdatePost;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Posts extends BaseResource
{
    /**
     * @param  string  $channelId  The channel ID to get the posts for
     * @param  int  $page  The page to select
     * @param  int  $since  Provide a non-zero value in Unix time milliseconds to select posts modified after that time
     * @param  string  $before  A post id to select the posts that came before this one
     * @param  bool  $includeDeleted  Whether to include deleted posts or not. Must have system admin permissions.
     */
    public function getPostsForChannel(
        string $channelId,
        ?int $page = null,
        ?int $since = null,
        ?string $before = null,
        ?bool $includeDeleted = null,
    ): Response {
        return $this->connector->send(new GetPostsForChannel($channelId, $page, $since, $before, $includeDeleted));
    }

    /**
     * @param  string|null  $channelId  The channel ID to post to.
     * @param  string|null  $message  The message contents (markdown supported).
     * @param  string|null  $rootId  The post ID to reply to. Creates a thread reply.
     * @param  array<int, string>|null  $fileIds  IDs of uploaded files to attach.
     * @param  array<string, mixed>|null  $props  Custom properties (e.g. `attachments`).
     * @param  bool|null  $setOnline  Whether to set the user status as online or not.
     */
    public function createPost(
        ?string $channelId = null,
        ?string $message = null,
        ?string $rootId = null,
        ?array $fileIds = null,
        ?array $props = null,
        ?bool $setOnline = null,
    ): Response {
        return $this->connector->send(new CreatePost($channelId, $message, $rootId, $fileIds, $props, $setOnline));
    }

    public function createPostEphemeral(): Response
    {
        return $this->connector->send(new CreatePostEphemeral);
    }

    public function getPostsByIds(): Response
    {
        return $this->connector->send(new GetPostsByIds);
    }

    /**
     * @param  string  $postId  ID of the post to get
     * @param  bool  $includeDeleted  Defines if result should include deleted posts, must have 'manage_system' (admin) permission.
     */
    public function getPost(string $postId, ?bool $includeDeleted = null): Response
    {
        return $this->connector->send(new GetPost($postId, $includeDeleted));
    }

    /**
     * @param  string  $postId  ID of the post to update
     */
    public function updatePost(string $postId): Response
    {
        return $this->connector->send(new UpdatePost($postId));
    }

    /**
     * @param  string  $postId  ID of the post to delete
     */
    public function deletePost(string $postId): Response
    {
        return $this->connector->send(new DeletePost($postId));
    }

    /**
     * @param  string  $postId  Post GUID
     * @param  string  $actionId  Action GUID
     */
    public function doPostAction(string $postId, string $actionId): Response
    {
        return $this->connector->send(new DoPostAction($postId, $actionId));
    }

    /**
     * @param  string  $postId  ID of the post
     * @param  bool  $includeDeleted  Defines if result should include deleted posts, must have 'manage_system' (admin) permission.
     */
    public function getFileInfosForPost(string $postId, ?bool $includeDeleted = null): Response
    {
        return $this->connector->send(new GetFileInfosForPost($postId, $includeDeleted));
    }

    /**
     * @param  string  $postId  Post GUID
     */
    public function patchPost(string $postId): Response
    {
        return $this->connector->send(new PatchPost($postId));
    }

    /**
     * @param  string  $postId  Post GUID
     */
    public function pinPost(string $postId): Response
    {
        return $this->connector->send(new PinPost($postId));
    }

    /**
     * @param  string  $postId  ID of a post in the thread
     * @param  int  $perPage  The number of posts per page
     * @param  string  $fromPost  The post_id to return the next page of posts from
     * @param  int  $fromCreateAt  The create_at timestamp to return the next page of posts from
     * @param  string  $direction  The direction to return the posts. Either up or down.
     * @param  bool  $skipFetchThreads  Whether to skip fetching threads or not
     * @param  bool  $collapsedThreads  Whether the client uses CRT or not
     * @param  bool  $collapsedThreadsExtended  Whether to return the associated users as part of the response or not
     */
    public function getPostThread(
        string $postId,
        ?int $perPage = null,
        ?string $fromPost = null,
        ?int $fromCreateAt = null,
        ?string $direction = null,
        ?bool $skipFetchThreads = null,
        ?bool $collapsedThreads = null,
        ?bool $collapsedThreadsExtended = null,
    ): Response {
        return $this->connector->send(new GetPostThread($postId, $perPage, $fromPost, $fromCreateAt, $direction, $skipFetchThreads, $collapsedThreads, $collapsedThreadsExtended));
    }

    /**
     * @param  string  $postId  Post GUID
     */
    public function unpinPost(string $postId): Response
    {
        return $this->connector->send(new UnpinPost($postId));
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function searchPosts(string $teamId): Response
    {
        return $this->connector->send(new SearchPosts($teamId));
    }

    /**
     * @param  string  $userId  ID of the user
     * @param  string  $channelId  The channel ID to get the posts for
     * @param  int  $limitBefore  Number of posts before the oldest unread posts. Maximum is 200 posts if limit is set greater than that.
     * @param  int  $limitAfter  Number of posts after and including the oldest unread post. Maximum is 200 posts if limit is set greater than that.
     * @param  bool  $skipFetchThreads  Whether to skip fetching threads or not
     * @param  bool  $collapsedThreads  Whether the client uses CRT or not
     * @param  bool  $collapsedThreadsExtended  Whether to return the associated users as part of the response or not
     */
    public function getPostsAroundLastUnread(
        string $userId,
        string $channelId,
        ?int $limitBefore = null,
        ?int $limitAfter = null,
        ?bool $skipFetchThreads = null,
        ?bool $collapsedThreads = null,
        ?bool $collapsedThreadsExtended = null,
    ): Response {
        return $this->connector->send(new GetPostsAroundLastUnread($userId, $channelId, $limitBefore, $limitAfter, $skipFetchThreads, $collapsedThreads, $collapsedThreadsExtended));
    }

    /**
     * @param  string  $userId  ID of the user
     * @param  string  $teamId  Team ID
     * @param  string  $channelId  Channel ID
     * @param  int  $page  The page to select
     */
    public function getFlaggedPostsForUser(
        string $userId,
        ?string $teamId = null,
        ?string $channelId = null,
        ?int $page = null,
    ): Response {
        return $this->connector->send(new GetFlaggedPostsForUser($userId, $teamId, $channelId, $page));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $postId  Post GUID
     */
    public function saveAcknowledgementForPost(string $userId, string $postId): Response
    {
        return $this->connector->send(new SaveAcknowledgementForPost($userId, $postId));
    }

    /**
     * @todo Fix duplicated method name
     *
     * @param  string  $userId  User GUID
     * @param  string  $postId  Post GUID
     */
    public function saveAcknowledgementForPostDuplicate1(string $userId, string $postId): Response
    {
        return $this->connector->send(new SaveAcknowledgementForPost($userId, $postId));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $postId  Post GUID
     */
    public function setPostReminder(string $userId, string $postId): Response
    {
        return $this->connector->send(new SetPostReminder($userId, $postId));
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $postId  Post GUID
     */
    public function setPostUnread(string $userId, string $postId): Response
    {
        return $this->connector->send(new SetPostUnread($userId, $postId));
    }
}
