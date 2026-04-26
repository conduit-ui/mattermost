<?php

declare(strict_types=1);

use ConduitUI\Mattermost\SlashCommands\SlashCommand;
use ConduitUI\Mattermost\SlashCommands\SlashCommandHandler;
use ConduitUI\Mattermost\SlashCommands\SlashCommandResponse;
use ConduitUI\Mattermost\SlashCommands\SlashCommandRouter;
use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('SlashCommandRouter', function (): void {
    it('dispatches to a registered class-based handler', function (): void {
        $router = app(SlashCommandRouter::class);
        $router->register('/deploy', StubDeployHandler::class);

        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy', 'production'));
        $response = $router->dispatch($command);

        expect($response)->not->toBeNull()
            ->and($response->toArray()['text'])->toBe('Deploying to production');
    });

    it('dispatches to a registered closure handler', function (): void {
        $router = app(SlashCommandRouter::class);
        $router->register('/status', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('All systems go'));

        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/status'));
        $response = $router->dispatch($command);

        expect($response)->not->toBeNull()
            ->and($response->toArray()['text'])->toBe('All systems go');
    });

    it('returns null for unregistered commands', function (): void {
        $router = app(SlashCommandRouter::class);

        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/unknown'));

        expect($router->dispatch($command))->toBeNull();
    });

    it('normalizes commands with missing leading slash', function (): void {
        $router = app(SlashCommandRouter::class);
        $router->register('deploy', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('OK'));

        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy'));
        $response = $router->dispatch($command);

        expect($response)->not->toBeNull()
            ->and($response->toArray()['text'])->toBe('OK');
    });

    it('checks handler registration via hasHandler', function (): void {
        $router = app(SlashCommandRouter::class);
        $router->register('/deploy', StubDeployHandler::class);

        expect($router->hasHandler('/deploy'))->toBeTrue()
            ->and($router->hasHandler('deploy'))->toBeTrue()
            ->and($router->hasHandler('/unknown'))->toBeFalse();
    });

    it('returns all registered handlers', function (): void {
        $router = app(SlashCommandRouter::class);
        $router->register('/deploy', StubDeployHandler::class);
        $router->register('/status', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('OK'));

        expect($router->handlers())->toHaveCount(2)
            ->and($router->handlers())->toHaveKeys(['/deploy', '/status']);
    });

    it('allows overwriting a previously registered handler', function (): void {
        $router = app(SlashCommandRouter::class);
        $router->register('/deploy', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('v1'));
        $router->register('/deploy', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('v2'));

        $command = SlashCommand::fromPayload(MattermostFixtures::fakeSlashCommand('/deploy'));
        $response = $router->dispatch($command);

        expect($response->toArray()['text'])->toBe('v2');
    });

    it('is chainable via register', function (): void {
        $router = app(SlashCommandRouter::class);

        $result = $router
            ->register('/a', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('a'))
            ->register('/b', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('b'));

        expect($result)->toBeInstanceOf(SlashCommandRouter::class)
            ->and($router->handlers())->toHaveCount(2);
    });
});

// --- Stub handler for testing ---

class StubDeployHandler extends SlashCommandHandler
{
    #[Override]
    public function handle(SlashCommand $command): SlashCommandResponse
    {
        $env = $command->arg(0, 'staging');

        return SlashCommandResponse::make("Deploying to {$env}")->inChannel();
    }
}
