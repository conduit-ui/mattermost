<?php

use ConduitUI\Mattermost\Client\Requests\System\GetPing;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\Facades\Mattermost;
use Saloon\Http\Faking\MockResponse;

describe('mattermost:health', function (): void {
    it('reports success when auth and ping both pass', function (): void {
        Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'bot-id', 'username' => 'testbot']),
            GetPing::class => MockResponse::make(['status' => 'OK', 'version' => '9.5.0']),
        ]);

        $this->artisan('mattermost:health')
            ->assertSuccessful();

        Mattermost::assertSent(GetUser::class);
        Mattermost::assertSent(GetPing::class);
    });

    it('displays the status table with server info', function (): void {
        Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'bot-id', 'username' => 'healthbot']),
            GetPing::class => MockResponse::make(['status' => 'OK', 'version' => '9.5.0']),
        ]);

        $this->artisan('mattermost:health')
            ->expectsOutputToContain('healthbot')
            ->expectsOutputToContain('9.5.0')
            ->assertSuccessful();
    });

    it('fails when the auth check returns an error response', function (): void {
        Mattermost::fake([
            GetUser::class => MockResponse::make(['message' => 'Unauthorized'], 401),
            GetPing::class => MockResponse::make(['status' => 'OK', 'version' => '9.5.0']),
        ]);

        $this->artisan('mattermost:health')
            ->assertFailed();
    });

    it('fails when the ping check returns a non-OK status', function (): void {
        Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'bot-id', 'username' => 'testbot']),
            GetPing::class => MockResponse::make(['status' => 'UNHEALTHY']),
        ]);

        $this->artisan('mattermost:health')
            ->assertFailed();
    });

    it('accepts a --connection option', function (): void {
        config()->set('mattermost.connections.secondary', [
            'url' => 'http://secondary:8065',
            'token' => 'secondary-token',
        ]);

        Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'bot-2', 'username' => 'bot2']),
            GetPing::class => MockResponse::make(['status' => 'OK', 'version' => '9.6.0']),
        ]);

        $this->artisan('mattermost:health', ['--connection' => 'secondary'])
            ->assertSuccessful();
    });
});
