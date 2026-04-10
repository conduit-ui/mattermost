<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Bots\GetBots;
use ConduitUI\Mattermost\Client\Requests\Bots\CreateBot;
use ConduitUI\Mattermost\Client\Requests\Bots\GetBot;
use ConduitUI\Mattermost\Client\Requests\Bots\PatchBot;
use ConduitUI\Mattermost\Client\Requests\Bots\AssignBot;
use ConduitUI\Mattermost\Client\Requests\Bots\ConvertBotToUser;
use ConduitUI\Mattermost\Client\Requests\Bots\DisableBot;
use ConduitUI\Mattermost\Client\Requests\Bots\EnableBot;
use ConduitUI\Mattermost\Client\Requests\Bots\ConvertUserToBot;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getBots method in the Bots resource', function () {
    Saloon::fake([
        GetBots::class => MockResponse::fixture('bots.getBots'),
    ]);

    $response = $this->mattermost->bots()->getBots(
		page: 123,
		includeDeleted: true,
		onlyOrphaned: true
	);

    Saloon::assertSent(GetBots::class);

    expect($response->status())->toBe(200);
});


it('calls the createBot method in the Bots resource', function () {
    Saloon::fake([
        CreateBot::class => MockResponse::fixture('bots.createBot'),
    ]);

    $response = $this->mattermost->bots()->createBot(
		
	);

    Saloon::assertSent(CreateBot::class);

    expect($response->status())->toBe(200);
});


it('calls the getBot method in the Bots resource', function () {
    Saloon::fake([
        GetBot::class => MockResponse::fixture('bots.getBot'),
    ]);

    $response = $this->mattermost->bots()->getBot(
		botUserId: 'test string',
		includeDeleted: true
	);

    Saloon::assertSent(GetBot::class);

    expect($response->status())->toBe(200);
});


it('calls the patchBot method in the Bots resource', function () {
    Saloon::fake([
        PatchBot::class => MockResponse::fixture('bots.patchBot'),
    ]);

    $response = $this->mattermost->bots()->patchBot(
		botUserId: 'test string'
	);

    Saloon::assertSent(PatchBot::class);

    expect($response->status())->toBe(200);
});


it('calls the assignBot method in the Bots resource', function () {
    Saloon::fake([
        AssignBot::class => MockResponse::fixture('bots.assignBot'),
    ]);

    $response = $this->mattermost->bots()->assignBot(
		botUserId: 'test string',
		userId: 'test string'
	);

    Saloon::assertSent(AssignBot::class);

    expect($response->status())->toBe(200);
});


it('calls the convertBotToUser method in the Bots resource', function () {
    Saloon::fake([
        ConvertBotToUser::class => MockResponse::fixture('bots.convertBotToUser'),
    ]);

    $response = $this->mattermost->bots()->convertBotToUser(
		botUserId: 'test string',
		setSystemAdmin: true
	);

    Saloon::assertSent(ConvertBotToUser::class);

    expect($response->status())->toBe(200);
});


it('calls the disableBot method in the Bots resource', function () {
    Saloon::fake([
        DisableBot::class => MockResponse::fixture('bots.disableBot'),
    ]);

    $response = $this->mattermost->bots()->disableBot(
		botUserId: 'test string'
	);

    Saloon::assertSent(DisableBot::class);

    expect($response->status())->toBe(200);
});


it('calls the enableBot method in the Bots resource', function () {
    Saloon::fake([
        EnableBot::class => MockResponse::fixture('bots.enableBot'),
    ]);

    $response = $this->mattermost->bots()->enableBot(
		botUserId: 'test string'
	);

    Saloon::assertSent(EnableBot::class);

    expect($response->status())->toBe(200);
});


it('calls the convertUserToBot method in the Bots resource', function () {
    Saloon::fake([
        ConvertUserToBot::class => MockResponse::fixture('bots.convertUserToBot'),
    ]);

    $response = $this->mattermost->bots()->convertUserToBot(
		userId: 'test string'
	);

    Saloon::assertSent(ConvertUserToBot::class);

    expect($response->status())->toBe(200);
});
