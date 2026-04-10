<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\System\MarkNoticesViewed;
use ConduitUI\Mattermost\Client\Requests\System\GetNotices;
use ConduitUI\Mattermost\Client\Requests\System\GetPing;
use ConduitUI\Mattermost\Client\Requests\System\GenerateSupportPacket;
use ConduitUI\Mattermost\Client\Requests\System\GetSupportedTimezone;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the markNoticesViewed method in the System resource', function () {
    Saloon::fake([
        MarkNoticesViewed::class => MockResponse::fixture('system.markNoticesViewed'),
    ]);

    $response = $this->mattermost->system()->markNoticesViewed(
		
	);

    Saloon::assertSent(MarkNoticesViewed::class);

    expect($response->status())->toBe(200);
});


it('calls the getNotices method in the System resource', function () {
    Saloon::fake([
        GetNotices::class => MockResponse::fixture('system.getNotices'),
    ]);

    $response = $this->mattermost->system()->getNotices(
		teamId: 'test string',
		clientVersion: 'test string',
		locale: 'test string',
		client: 'test string'
	);

    Saloon::assertSent(GetNotices::class);

    expect($response->status())->toBe(200);
});


it('calls the getPing method in the System resource', function () {
    Saloon::fake([
        GetPing::class => MockResponse::fixture('system.getPing'),
    ]);

    $response = $this->mattermost->system()->getPing(
		getServerStatus: true,
		deviceId: 'test string'
	);

    Saloon::assertSent(GetPing::class);

    expect($response->status())->toBe(200);
});


it('calls the generateSupportPacket method in the System resource', function () {
    Saloon::fake([
        GenerateSupportPacket::class => MockResponse::fixture('system.generateSupportPacket'),
    ]);

    $response = $this->mattermost->system()->generateSupportPacket(
		
	);

    Saloon::assertSent(GenerateSupportPacket::class);

    expect($response->status())->toBe(200);
});


it('calls the getSupportedTimezone method in the System resource', function () {
    Saloon::fake([
        GetSupportedTimezone::class => MockResponse::fixture('system.getSupportedTimezone'),
    ]);

    $response = $this->mattermost->system()->getSupportedTimezone(
		
	);

    Saloon::assertSent(GetSupportedTimezone::class);

    expect($response->status())->toBe(200);
});
