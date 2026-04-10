<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsByChannel;
use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsByTeam;
use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsAssociatedToChannelsByTeam;
use ConduitUI\Mattermost\Client\Requests\Groups\GetGroupsByUserId;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getGroupsByChannel method in the Groups resource', function () {
    Saloon::fake([
        GetGroupsByChannel::class => MockResponse::fixture('groups.getGroupsByChannel'),
    ]);

    $response = $this->mattermost->groups()->getGroupsByChannel(
		channelId: 'test string',
		page: 123,
		filterAllowReference: true
	);

    Saloon::assertSent(GetGroupsByChannel::class);

    expect($response->status())->toBe(200);
});


it('calls the getGroupsByTeam method in the Groups resource', function () {
    Saloon::fake([
        GetGroupsByTeam::class => MockResponse::fixture('groups.getGroupsByTeam'),
    ]);

    $response = $this->mattermost->groups()->getGroupsByTeam(
		teamId: 'test string',
		page: 123,
		filterAllowReference: true
	);

    Saloon::assertSent(GetGroupsByTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the getGroupsAssociatedToChannelsByTeam method in the Groups resource', function () {
    Saloon::fake([
        GetGroupsAssociatedToChannelsByTeam::class => MockResponse::fixture('groups.getGroupsAssociatedToChannelsByTeam'),
    ]);

    $response = $this->mattermost->groups()->getGroupsAssociatedToChannelsByTeam(
		teamId: 'test string',
		page: 123,
		filterAllowReference: true,
		paginate: true
	);

    Saloon::assertSent(GetGroupsAssociatedToChannelsByTeam::class);

    expect($response->status())->toBe(200);
});


it('calls the getGroupsByUserId method in the Groups resource', function () {
    Saloon::fake([
        GetGroupsByUserId::class => MockResponse::fixture('groups.getGroupsByUserId'),
    ]);

    $response = $this->mattermost->groups()->getGroupsByUserId(
		userId: 'test string'
	);

    Saloon::assertSent(GetGroupsByUserId::class);

    expect($response->status())->toBe(200);
});
