<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\DataRetention\GetChannelPoliciesForUser;
use ConduitUI\Mattermost\Client\Requests\DataRetention\GetTeamPoliciesForUser;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getChannelPoliciesForUser method in the DataRetention resource', function () {
    Saloon::fake([
        GetChannelPoliciesForUser::class => MockResponse::fixture('dataRetention.getChannelPoliciesForUser'),
    ]);

    $response = $this->mattermost->dataRetention()->getChannelPoliciesForUser(
		userId: 'test string',
		page: 123
	);

    Saloon::assertSent(GetChannelPoliciesForUser::class);

    expect($response->status())->toBe(200);
});


it('calls the getTeamPoliciesForUser method in the DataRetention resource', function () {
    Saloon::fake([
        GetTeamPoliciesForUser::class => MockResponse::fixture('dataRetention.getTeamPoliciesForUser'),
    ]);

    $response = $this->mattermost->dataRetention()->getTeamPoliciesForUser(
		userId: 'test string',
		page: 123
	);

    Saloon::assertSent(GetTeamPoliciesForUser::class);

    expect($response->status())->toBe(200);
});
