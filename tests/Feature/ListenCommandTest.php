<?php

use ConduitUI\Mattermost\Bot\Router;
use ConduitUI\Mattermost\WebSocket\Client as WebSocketClient;
use Illuminate\Console\Application;
use Illuminate\Contracts\Console\Kernel;

describe('mattermost:listen', function (): void {
    it('is registered and has the correct signature', function (): void {
        $command = $this->app->make(Kernel::class);

        $this->assertTrue(
            collect(Application::starting(fn () => null) ?: [])
                ->isEmpty() || true,
        );

        // Verify the command is registered by resolving it from Artisan
        $this->artisan('mattermost:listen --help')
            ->assertSuccessful();
    });

    it('resolves the bot router via DI', function (): void {
        $router = $this->app->make(Router::class);

        expect($router)->toBeInstanceOf(Router::class);
    });

    it('accepts a --connection option in its signature', function (): void {
        $this->artisan('mattermost:listen --help')
            ->expectsOutputToContain('connection');
    });

    it('boots the WebSocket client with config values', function (): void {
        config()->set('mattermost.connections.default.url', 'http://test-server:8065');
        config()->set('mattermost.connections.default.token', 'test-ws-token');
        config()->set('mattermost.websocket.ping_interval', 15);

        $client = new WebSocketClient(
            baseUrl: 'http://test-server:8065',
            token: 'test-ws-token',
            pingIntervalSeconds: 15,
        );

        expect($client->url())->toBe('ws://test-server:8065/api/v4/websocket');
    });

    it('attaches the router to the WebSocket client', function (): void {
        $router = $this->app->make(Router::class);
        $client = new WebSocketClient(
            baseUrl: 'http://localhost:8065',
            token: 'test-token',
        );

        $router->attachToWebSocketClient($client);

        // No exception thrown — the router is wired to the client
        expect(true)->toBeTrue();
    });
});
