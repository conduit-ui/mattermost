<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Threads\GetUserThreads;
use ConduitUI\Mattermost\Client\Requests\Threads\GetThreadMentionCountsByChannel;
use ConduitUI\Mattermost\Client\Requests\Threads\UpdateThreadsReadForUser;
use ConduitUI\Mattermost\Client\Requests\Threads\GetUserThread;
use ConduitUI\Mattermost\Client\Requests\Threads\StartFollowingThread;
use ConduitUI\Mattermost\Client\Requests\Threads\StopFollowingThread;
use ConduitUI\Mattermost\Client\Requests\Threads\UpdateThreadReadForUser;
use ConduitUI\Mattermost\Client\Requests\Threads\SetThreadUnreadByPostId;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getUserThreads method in the Threads resource', function () {
    Saloon::fake([
        GetUserThreads::class => MockResponse::fixture('threads.getUserThreads'),
    ]);

    $response = $this->mattermost->threads()->getUserThreads(
		userId: 'test string',
		teamId: 'test string',
		since: 123,
		deleted: true,
		extended: true,
		page: 123,
		pageSize: 123,
		totalsOnly: true,
		threadsOnly: true
	);

    Saloon::assertSent(GetUserThreads::class);

    expect($response->status())->toBe(200);
});


it('calls the getThreadMentionCountsByChannel method in the Threads resource', function () {
    Saloon::fake([
        GetThreadMentionCountsByChannel::class => MockResponse::fixture('threads.getThreadMentionCountsByChannel'),
    ]);

    $response = $this->mattermost->threads()->getThreadMentionCountsByChannel(
		userId: 'test string',
		teamId: 'test string'
	);

    Saloon::assertSent(GetThreadMentionCountsByChannel::class);

    expect($response->status())->toBe(200);
});


it('calls the updateThreadsReadForUser method in the Threads resource', function () {
    Saloon::fake([
        UpdateThreadsReadForUser::class => MockResponse::fixture('threads.updateThreadsReadForUser'),
    ]);

    $response = $this->mattermost->threads()->updateThreadsReadForUser(
		userId: 'test string',
		teamId: 'test string'
	);

    Saloon::assertSent(UpdateThreadsReadForUser::class);

    expect($response->status())->toBe(200);
});


it('calls the getUserThread method in the Threads resource', function () {
    Saloon::fake([
        GetUserThread::class => MockResponse::fixture('threads.getUserThread'),
    ]);

    $response = $this->mattermost->threads()->getUserThread(
		userId: 'test string',
		teamId: 'test string',
		threadId: 'test string'
	);

    Saloon::assertSent(GetUserThread::class);

    expect($response->status())->toBe(200);
});


it('calls the startFollowingThread method in the Threads resource', function () {
    Saloon::fake([
        StartFollowingThread::class => MockResponse::fixture('threads.startFollowingThread'),
    ]);

    $response = $this->mattermost->threads()->startFollowingThread(
		userId: 'test string',
		teamId: 'test string',
		threadId: 'test string'
	);

    Saloon::assertSent(StartFollowingThread::class);

    expect($response->status())->toBe(200);
});


it('calls the stopFollowingThread method in the Threads resource', function () {
    Saloon::fake([
        StopFollowingThread::class => MockResponse::fixture('threads.stopFollowingThread'),
    ]);

    $response = $this->mattermost->threads()->stopFollowingThread(
		userId: 'test string',
		teamId: 'test string',
		threadId: 'test string'
	);

    Saloon::assertSent(StopFollowingThread::class);

    expect($response->status())->toBe(200);
});


it('calls the updateThreadReadForUser method in the Threads resource', function () {
    Saloon::fake([
        UpdateThreadReadForUser::class => MockResponse::fixture('threads.updateThreadReadForUser'),
    ]);

    $response = $this->mattermost->threads()->updateThreadReadForUser(
		userId: 'test string',
		teamId: 'test string',
		threadId: 'test string',
		timestamp: 'test string'
	);

    Saloon::assertSent(UpdateThreadReadForUser::class);

    expect($response->status())->toBe(200);
});


it('calls the setThreadUnreadByPostId method in the Threads resource', function () {
    Saloon::fake([
        SetThreadUnreadByPostId::class => MockResponse::fixture('threads.setThreadUnreadByPostId'),
    ]);

    $response = $this->mattermost->threads()->setThreadUnreadByPostId(
		userId: 'test string',
		teamId: 'test string',
		threadId: 'test string',
		postId: 'test string'
	);

    Saloon::assertSent(SetThreadUnreadByPostId::class);

    expect($response->status())->toBe(200);
});
