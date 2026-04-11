<?php

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\MattermostManager;

it('resolves default connection from config', function (): void {
    $manager = app(MattermostManager::class);
    $client = $manager->connection();

    expect($client)->toBeInstanceOf(Mattermost::class);
    expect($client->resolveBaseUrl())->toBe('http://localhost:8065');
});

it('caches connections', function (): void {
    $manager = app(MattermostManager::class);

    $first = $manager->connection();
    $second = $manager->connection();

    expect($first)->toBe($second);
});

it('resolves named connections', function (): void {
    config(['mattermost.connections.prod' => [
        'url' => 'https://mm.production.com',
        'token' => 'prod-token',
    ]]);

    $manager = app(MattermostManager::class);
    $client = $manager->connection('prod');

    expect($client->resolveBaseUrl())->toBe('https://mm.production.com');
});

it('throws on unconfigured connection', function (): void {
    $manager = app(MattermostManager::class);
    $manager->connection('nonexistent');
})->throws(InvalidArgumentException::class, 'not configured');

it('purges cached connection', function (): void {
    $manager = app(MattermostManager::class);

    $first = $manager->connection();
    $manager->purge();
    $second = $manager->connection();

    expect($first)->not->toBe($second);
});

it('is registered as scoped singleton', function (): void {
    $first = app(MattermostManager::class);
    $second = app(MattermostManager::class);

    expect($first)->toBe($second);
});
