<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Status\GetUsersStatusesByIds;
use ConduitUI\Mattermost\Client\Requests\Status\GetUserStatus;
use ConduitUI\Mattermost\Client\Requests\Status\PostUserRecentCustomStatusDelete;
use ConduitUI\Mattermost\Client\Requests\Status\RemoveRecentCustomStatus;
use ConduitUI\Mattermost\Client\Requests\Status\UnsetUserCustomStatus;
use ConduitUI\Mattermost\Client\Requests\Status\UpdateUserCustomStatus;
use ConduitUI\Mattermost\Client\Requests\Status\UpdateUserStatus;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getUsersStatusesByIds method in the Status resource', function (): void {
    Saloon::fake([
        GetUsersStatusesByIds::class => MockResponse::fixture('status.getUsersStatusesByIds'),
    ]);

    $response = $this->mattermost->status()->getUsersStatusesByIds(

    );

    Saloon::assertSent(GetUsersStatusesByIds::class);

    expect($response->status())->toBe(200);
});

it('calls the getUserStatus method in the Status resource', function (): void {
    Saloon::fake([
        GetUserStatus::class => MockResponse::fixture('status.getUserStatus'),
    ]);

    $response = $this->mattermost->status()->getUserStatus(
        userId: 'test string'
    );

    Saloon::assertSent(GetUserStatus::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserStatus method in the Status resource', function (): void {
    Saloon::fake([
        UpdateUserStatus::class => MockResponse::fixture('status.updateUserStatus'),
    ]);

    $response = $this->mattermost->status()->updateUserStatus(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserStatus::class);

    expect($response->status())->toBe(200);
});

it('calls the updateUserCustomStatus method in the Status resource', function (): void {
    Saloon::fake([
        UpdateUserCustomStatus::class => MockResponse::fixture('status.updateUserCustomStatus'),
    ]);

    $response = $this->mattermost->status()->updateUserCustomStatus(
        userId: 'test string'
    );

    Saloon::assertSent(UpdateUserCustomStatus::class);

    expect($response->status())->toBe(200);
});

it('calls the unsetUserCustomStatus method in the Status resource', function (): void {
    Saloon::fake([
        UnsetUserCustomStatus::class => MockResponse::fixture('status.unsetUserCustomStatus'),
    ]);

    $response = $this->mattermost->status()->unsetUserCustomStatus(
        userId: 'test string'
    );

    Saloon::assertSent(UnsetUserCustomStatus::class);

    expect($response->status())->toBe(200);
});

it('calls the removeRecentCustomStatus method in the Status resource', function (): void {
    Saloon::fake([
        RemoveRecentCustomStatus::class => MockResponse::fixture('status.removeRecentCustomStatus'),
    ]);

    $response = $this->mattermost->status()->removeRecentCustomStatus(
        userId: 'test string'
    );

    Saloon::assertSent(RemoveRecentCustomStatus::class);

    expect($response->status())->toBe(200);
});

it('calls the postUserRecentCustomStatusDelete method in the Status resource', function (): void {
    Saloon::fake([
        PostUserRecentCustomStatusDelete::class => MockResponse::fixture('status.postUserRecentCustomStatusDelete'),
    ]);

    $response = $this->mattermost->status()->postUserRecentCustomStatusDelete(
        userId: 'test string'
    );

    Saloon::assertSent(PostUserRecentCustomStatusDelete::class);

    expect($response->status())->toBe(200);
});
