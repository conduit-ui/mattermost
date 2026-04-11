<?php

use ConduitUI\Mattermost\Client\Resource\Channels;
use ConduitUI\Mattermost\Client\Resource\Posts;
use ConduitUI\Mattermost\Client\Resource\Users;
use ConduitUI\Mattermost\Facades\Mattermost;

it('resolves the facade root to MattermostManager', function (): void {
    expect(Mattermost::connection())->toBeInstanceOf(ConduitUI\Mattermost\Client\Mattermost::class);
});

it('proxies resource calls to default connection', function (): void {
    expect(Mattermost::posts())->toBeInstanceOf(Posts::class);
    expect(Mattermost::channels())->toBeInstanceOf(Channels::class);
    expect(Mattermost::users())->toBeInstanceOf(Users::class);
});

it('supports named connections via facade', function (): void {
    config(['mattermost.connections.staging' => [
        'url' => 'https://staging.mm.com',
        'token' => 'staging-token',
    ]]);

    $client = Mattermost::connection('staging');
    expect($client->resolveBaseUrl())->toBe('https://staging.mm.com');
});
