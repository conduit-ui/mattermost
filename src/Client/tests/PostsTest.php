<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
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
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getPostsForChannel method in the Posts resource', function (): void {
    Saloon::fake([
        GetPostsForChannel::class => MockResponse::fixture('posts.getPostsForChannel'),
    ]);

    $response = $this->mattermost->posts()->getPostsForChannel(
        channelId: 'test string',
        page: 123,
        since: 123,
        before: 'test string',
        includeDeleted: true
    );

    Saloon::assertSent(GetPostsForChannel::class);

    expect($response->status())->toBe(200);
});

it('calls the createPost method in the Posts resource', function (): void {
    Saloon::fake([
        CreatePost::class => MockResponse::fixture('posts.createPost'),
    ]);

    $response = $this->mattermost->posts()->createPost(
        setOnline: true
    );

    Saloon::assertSent(CreatePost::class);

    expect($response->status())->toBe(200);
});

it('calls the createPostEphemeral method in the Posts resource', function (): void {
    Saloon::fake([
        CreatePostEphemeral::class => MockResponse::fixture('posts.createPostEphemeral'),
    ]);

    $response = $this->mattermost->posts()->createPostEphemeral(

    );

    Saloon::assertSent(CreatePostEphemeral::class);

    expect($response->status())->toBe(200);
});

it('calls the getPostsByIds method in the Posts resource', function (): void {
    Saloon::fake([
        GetPostsByIds::class => MockResponse::fixture('posts.getPostsByIds'),
    ]);

    $response = $this->mattermost->posts()->getPostsByIds(

    );

    Saloon::assertSent(GetPostsByIds::class);

    expect($response->status())->toBe(200);
});

it('calls the getPost method in the Posts resource', function (): void {
    Saloon::fake([
        GetPost::class => MockResponse::fixture('posts.getPost'),
    ]);

    $response = $this->mattermost->posts()->getPost(
        postId: 'test string',
        includeDeleted: true
    );

    Saloon::assertSent(GetPost::class);

    expect($response->status())->toBe(200);
});

it('calls the updatePost method in the Posts resource', function (): void {
    Saloon::fake([
        UpdatePost::class => MockResponse::fixture('posts.updatePost'),
    ]);

    $response = $this->mattermost->posts()->updatePost(
        postId: 'test string'
    );

    Saloon::assertSent(UpdatePost::class);

    expect($response->status())->toBe(200);
});

it('calls the deletePost method in the Posts resource', function (): void {
    Saloon::fake([
        DeletePost::class => MockResponse::fixture('posts.deletePost'),
    ]);

    $response = $this->mattermost->posts()->deletePost(
        postId: 'test string'
    );

    Saloon::assertSent(DeletePost::class);

    expect($response->status())->toBe(200);
});

it('calls the doPostAction method in the Posts resource', function (): void {
    Saloon::fake([
        DoPostAction::class => MockResponse::fixture('posts.doPostAction'),
    ]);

    $response = $this->mattermost->posts()->doPostAction(
        postId: 'test string',
        actionId: 'test string'
    );

    Saloon::assertSent(DoPostAction::class);

    expect($response->status())->toBe(200);
});

it('calls the getFileInfosForPost method in the Posts resource', function (): void {
    Saloon::fake([
        GetFileInfosForPost::class => MockResponse::fixture('posts.getFileInfosForPost'),
    ]);

    $response = $this->mattermost->posts()->getFileInfosForPost(
        postId: 'test string',
        includeDeleted: true
    );

    Saloon::assertSent(GetFileInfosForPost::class);

    expect($response->status())->toBe(200);
});

it('calls the patchPost method in the Posts resource', function (): void {
    Saloon::fake([
        PatchPost::class => MockResponse::fixture('posts.patchPost'),
    ]);

    $response = $this->mattermost->posts()->patchPost(
        postId: 'test string'
    );

    Saloon::assertSent(PatchPost::class);

    expect($response->status())->toBe(200);
});

it('calls the pinPost method in the Posts resource', function (): void {
    Saloon::fake([
        PinPost::class => MockResponse::fixture('posts.pinPost'),
    ]);

    $response = $this->mattermost->posts()->pinPost(
        postId: 'test string'
    );

    Saloon::assertSent(PinPost::class);

    expect($response->status())->toBe(200);
});

it('calls the getPostThread method in the Posts resource', function (): void {
    Saloon::fake([
        GetPostThread::class => MockResponse::fixture('posts.getPostThread'),
    ]);

    $response = $this->mattermost->posts()->getPostThread(
        postId: 'test string',
        perPage: 123,
        fromPost: 'test string',
        fromCreateAt: 123,
        direction: 'test string',
        skipFetchThreads: true,
        collapsedThreads: true,
        collapsedThreadsExtended: true
    );

    Saloon::assertSent(GetPostThread::class);

    expect($response->status())->toBe(200);
});

it('calls the unpinPost method in the Posts resource', function (): void {
    Saloon::fake([
        UnpinPost::class => MockResponse::fixture('posts.unpinPost'),
    ]);

    $response = $this->mattermost->posts()->unpinPost(
        postId: 'test string'
    );

    Saloon::assertSent(UnpinPost::class);

    expect($response->status())->toBe(200);
});

it('calls the searchPosts method in the Posts resource', function (): void {
    Saloon::fake([
        SearchPosts::class => MockResponse::fixture('posts.searchPosts'),
    ]);

    $response = $this->mattermost->posts()->searchPosts(
        teamId: 'test string'
    );

    Saloon::assertSent(SearchPosts::class);

    expect($response->status())->toBe(200);
});

it('calls the getPostsAroundLastUnread method in the Posts resource', function (): void {
    Saloon::fake([
        GetPostsAroundLastUnread::class => MockResponse::fixture('posts.getPostsAroundLastUnread'),
    ]);

    $response = $this->mattermost->posts()->getPostsAroundLastUnread(
        userId: 'test string',
        channelId: 'test string',
        limitBefore: 123,
        limitAfter: 123,
        skipFetchThreads: true,
        collapsedThreads: true,
        collapsedThreadsExtended: true
    );

    Saloon::assertSent(GetPostsAroundLastUnread::class);

    expect($response->status())->toBe(200);
});

it('calls the getFlaggedPostsForUser method in the Posts resource', function (): void {
    Saloon::fake([
        GetFlaggedPostsForUser::class => MockResponse::fixture('posts.getFlaggedPostsForUser'),
    ]);

    $response = $this->mattermost->posts()->getFlaggedPostsForUser(
        userId: 'test string',
        teamId: 'test string',
        channelId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetFlaggedPostsForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the saveAcknowledgementForPost method in the Posts resource', function (): void {
    Saloon::fake([
        SaveAcknowledgementForPost::class => MockResponse::fixture('posts.saveAcknowledgementForPost'),
    ]);

    $response = $this->mattermost->posts()->saveAcknowledgementForPost(
        userId: 'test string',
        postId: 'test string'
    );

    Saloon::assertSent(SaveAcknowledgementForPost::class);

    expect($response->status())->toBe(200);
});

it('calls the saveAcknowledgementForPost method in the Posts resource', function (): void {
    Saloon::fake([
        SaveAcknowledgementForPost::class => MockResponse::fixture('posts.saveAcknowledgementForPost'),
    ]);

    $response = $this->mattermost->posts()->saveAcknowledgementForPost(
        userId: 'test string',
        postId: 'test string'
    );

    Saloon::assertSent(SaveAcknowledgementForPost::class);

    expect($response->status())->toBe(200);
});

it('calls the setPostReminder method in the Posts resource', function (): void {
    Saloon::fake([
        SetPostReminder::class => MockResponse::fixture('posts.setPostReminder'),
    ]);

    $response = $this->mattermost->posts()->setPostReminder(
        userId: 'test string',
        postId: 'test string'
    );

    Saloon::assertSent(SetPostReminder::class);

    expect($response->status())->toBe(200);
});

it('calls the setPostUnread method in the Posts resource', function (): void {
    Saloon::fake([
        SetPostUnread::class => MockResponse::fixture('posts.setPostUnread'),
    ]);

    $response = $this->mattermost->posts()->setPostUnread(
        userId: 'test string',
        postId: 'test string'
    );

    Saloon::assertSent(SetPostUnread::class);

    expect($response->status())->toBe(200);
});
