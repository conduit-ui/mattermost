<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Insights\GetNewTeamMembers;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopChannelsForTeam;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopChannelsForUser;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopDmsForUser;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopReactionsForTeam;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopReactionsForUser;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopThreadsForTeam;
use ConduitUI\Mattermost\Client\Requests\Insights\GetTopThreadsForUser;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getTopChannelsForTeam method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopChannelsForTeam::class => MockResponse::fixture('insights.getTopChannelsForTeam'),
    ]);

    $response = $this->mattermost->insights()->getTopChannelsForTeam(
        teamId: 'test string',
        timeRange: 'test string',
        page: 123
    );

    Saloon::assertSent(GetTopChannelsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the getTopReactionsForTeam method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopReactionsForTeam::class => MockResponse::fixture('insights.getTopReactionsForTeam'),
    ]);

    $response = $this->mattermost->insights()->getTopReactionsForTeam(
        teamId: 'test string',
        timeRange: 'test string',
        page: 123
    );

    Saloon::assertSent(GetTopReactionsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the getNewTeamMembers method in the Insights resource', function (): void {
    Saloon::fake([
        GetNewTeamMembers::class => MockResponse::fixture('insights.getNewTeamMembers'),
    ]);

    $response = $this->mattermost->insights()->getNewTeamMembers(
        teamId: 'test string',
        timeRange: 'test string',
        page: 123
    );

    Saloon::assertSent(GetNewTeamMembers::class);

    expect($response->status())->toBe(200);
});

it('calls the getTopThreadsForTeam method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopThreadsForTeam::class => MockResponse::fixture('insights.getTopThreadsForTeam'),
    ]);

    $response = $this->mattermost->insights()->getTopThreadsForTeam(
        teamId: 'test string',
        timeRange: 'test string',
        page: 123
    );

    Saloon::assertSent(GetTopThreadsForTeam::class);

    expect($response->status())->toBe(200);
});

it('calls the getTopChannelsForUser method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopChannelsForUser::class => MockResponse::fixture('insights.getTopChannelsForUser'),
    ]);

    $response = $this->mattermost->insights()->getTopChannelsForUser(
        timeRange: 'test string',
        page: 123,
        teamId: 'test string'
    );

    Saloon::assertSent(GetTopChannelsForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getTopDmsForUser method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopDmsForUser::class => MockResponse::fixture('insights.getTopDmsForUser'),
    ]);

    $response = $this->mattermost->insights()->getTopDmsForUser(
        timeRange: 'test string',
        page: 123
    );

    Saloon::assertSent(GetTopDmsForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getTopReactionsForUser method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopReactionsForUser::class => MockResponse::fixture('insights.getTopReactionsForUser'),
    ]);

    $response = $this->mattermost->insights()->getTopReactionsForUser(
        timeRange: 'test string',
        page: 123,
        teamId: 'test string'
    );

    Saloon::assertSent(GetTopReactionsForUser::class);

    expect($response->status())->toBe(200);
});

it('calls the getTopThreadsForUser method in the Insights resource', function (): void {
    Saloon::fake([
        GetTopThreadsForUser::class => MockResponse::fixture('insights.getTopThreadsForUser'),
    ]);

    $response = $this->mattermost->insights()->getTopThreadsForUser(
        timeRange: 'test string',
        page: 123,
        teamId: 'test string'
    );

    Saloon::assertSent(GetTopThreadsForUser::class);

    expect($response->status())->toBe(200);
});
