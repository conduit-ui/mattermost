<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\Notifications\MattermostBroadcaster;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\Factory as BroadcastFactory;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function (): void {
    $this->mock = MockClient::global([
        CreatePost::class => MockResponse::make(['id' => 'post-1'], 201),
    ]);

    config(['broadcasting.connections.mattermost' => [
        'driver' => 'mattermost',
        'connection' => 'default',
    ]]);
});

afterEach(function (): void {
    MockClient::destroyGlobal();
});

describe('MattermostBroadcaster', function (): void {
    it('posts each broadcast channel as a Mattermost message', function (): void {
        $broadcaster = new MattermostBroadcaster(app(MattermostManager::class));

        $broadcaster->broadcast(
            [new Channel('chan-a'), new Channel('chan-b')],
            'OrderShipped',
            ['order_id' => 7],
        );

        $sent = collect($this->mock->getRecordedResponses())
            ->map(fn ($response): ?array => $response->getPendingRequest()->body()?->all())
            ->all();

        expect($sent)->toHaveCount(2);
        expect($sent[0]['channel_id'])->toBe('chan-a');
        expect($sent[1]['channel_id'])->toBe('chan-b');

        expect($sent[0]['message'])->toContain('OrderShipped');
        expect($sent[0]['message'])->toContain('"order_id": 7');
    });

    it('uses the configured named connection', function (): void {
        config(['mattermost.connections.events' => [
            'url' => 'https://events.mm.test',
            'token' => 'events-token',
        ]]);

        $manager = app(MattermostManager::class);
        $broadcaster = new MattermostBroadcaster($manager, 'events');

        $broadcaster->broadcast([new Channel('chan-1')], 'Ping', []);

        expect($manager->connection('events')->resolveBaseUrl())->toBe('https://events.mm.test');
        $this->mock->assertSent(CreatePost::class);
    });

    it('is registered as a broadcasting driver via the service provider', function (): void {
        /** @var BroadcastFactory $factory */
        $factory = app(BroadcastFactory::class);

        $driver = $factory->driver('mattermost');

        expect($driver)->toBeInstanceOf(MattermostBroadcaster::class);
    });
});
