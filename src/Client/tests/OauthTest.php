<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Oauth\GetAuthorizedOauthAppsForUser;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getAuthorizedOauthAppsForUser method in the Oauth resource', function (): void {
    Saloon::fake([
        GetAuthorizedOauthAppsForUser::class => MockResponse::fixture('oauth.getAuthorizedOauthAppsForUser'),
    ]);

    $response = $this->mattermost->oauth()->getAuthorizedOauthAppsForUser(
        userId: 'test string',
        page: 123
    );

    Saloon::assertSent(GetAuthorizedOauthAppsForUser::class);

    expect($response->status())->toBe(200);
});
