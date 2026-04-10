<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Webhooks\GetIncomingWebhooks;
use ConduitUI\Mattermost\Client\Requests\Webhooks\CreateIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\UpdateIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\DeleteIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetOutgoingWebhooks;
use ConduitUI\Mattermost\Client\Requests\Webhooks\CreateOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\UpdateOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\DeleteOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\RegenOutgoingHookToken;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getIncomingWebhooks method in the Webhooks resource', function () {
    Saloon::fake([
        GetIncomingWebhooks::class => MockResponse::fixture('webhooks.getIncomingWebhooks'),
    ]);

    $response = $this->mattermost->webhooks()->getIncomingWebhooks(
		page: 123,
		teamId: 'test string'
	);

    Saloon::assertSent(GetIncomingWebhooks::class);

    expect($response->status())->toBe(200);
});


it('calls the createIncomingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        CreateIncomingWebhook::class => MockResponse::fixture('webhooks.createIncomingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->createIncomingWebhook(
		
	);

    Saloon::assertSent(CreateIncomingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the getIncomingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        GetIncomingWebhook::class => MockResponse::fixture('webhooks.getIncomingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->getIncomingWebhook(
		hookId: 'test string'
	);

    Saloon::assertSent(GetIncomingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the updateIncomingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        UpdateIncomingWebhook::class => MockResponse::fixture('webhooks.updateIncomingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->updateIncomingWebhook(
		hookId: 'test string'
	);

    Saloon::assertSent(UpdateIncomingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the deleteIncomingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        DeleteIncomingWebhook::class => MockResponse::fixture('webhooks.deleteIncomingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->deleteIncomingWebhook(
		hookId: 'test string'
	);

    Saloon::assertSent(DeleteIncomingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the getOutgoingWebhooks method in the Webhooks resource', function () {
    Saloon::fake([
        GetOutgoingWebhooks::class => MockResponse::fixture('webhooks.getOutgoingWebhooks'),
    ]);

    $response = $this->mattermost->webhooks()->getOutgoingWebhooks(
		page: 123,
		teamId: 'test string',
		channelId: 'test string'
	);

    Saloon::assertSent(GetOutgoingWebhooks::class);

    expect($response->status())->toBe(200);
});


it('calls the createOutgoingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        CreateOutgoingWebhook::class => MockResponse::fixture('webhooks.createOutgoingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->createOutgoingWebhook(
		
	);

    Saloon::assertSent(CreateOutgoingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the getOutgoingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        GetOutgoingWebhook::class => MockResponse::fixture('webhooks.getOutgoingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->getOutgoingWebhook(
		hookId: 'test string'
	);

    Saloon::assertSent(GetOutgoingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the updateOutgoingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        UpdateOutgoingWebhook::class => MockResponse::fixture('webhooks.updateOutgoingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->updateOutgoingWebhook(
		hookId: 'test string'
	);

    Saloon::assertSent(UpdateOutgoingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the deleteOutgoingWebhook method in the Webhooks resource', function () {
    Saloon::fake([
        DeleteOutgoingWebhook::class => MockResponse::fixture('webhooks.deleteOutgoingWebhook'),
    ]);

    $response = $this->mattermost->webhooks()->deleteOutgoingWebhook(
		hookId: 'test string'
	);

    Saloon::assertSent(DeleteOutgoingWebhook::class);

    expect($response->status())->toBe(200);
});


it('calls the regenOutgoingHookToken method in the Webhooks resource', function () {
    Saloon::fake([
        RegenOutgoingHookToken::class => MockResponse::fixture('webhooks.regenOutgoingHookToken'),
    ]);

    $response = $this->mattermost->webhooks()->regenOutgoingHookToken(
		hookId: 'test string'
	);

    Saloon::assertSent(RegenOutgoingHookToken::class);

    expect($response->status())->toBe(200);
});
