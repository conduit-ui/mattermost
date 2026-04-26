<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\SlashCommands\SlashCommand;
use ConduitUI\Mattermost\SlashCommands\SlashCommandResponse;
use ConduitUI\Mattermost\SlashCommands\SlashCommandRouter;

describe('SlashCommands ServiceProvider', function (): void {
    it('registers the SlashCommandRouter as a singleton', function (): void {
        $router1 = app(SlashCommandRouter::class);
        $router2 = app(SlashCommandRouter::class);

        expect($router1)->toBeInstanceOf(SlashCommandRouter::class)
            ->and($router1)->toBe($router2);
    });

    it('registers the webhook route', function (): void {
        $route = app('router')->getRoutes()->getByName('mattermost.slash-command');

        expect($route)->not->toBeNull()
            ->and($route->uri())->toBe('mattermost/slash-command')
            ->and($route->methods())->toContain('POST');
    });

    it('proxies slash() through the Facade to the router', function (): void {
        Mattermost::slash('/test', fn (SlashCommand $cmd): SlashCommandResponse => SlashCommandResponse::make('OK'));

        /** @var SlashCommandRouter $router */
        $router = app(SlashCommandRouter::class);

        expect($router->hasHandler('/test'))->toBeTrue();
    });
});
