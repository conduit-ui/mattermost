<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\IgnoreBots;
use ConduitUI\Mattermost\Bot\Router;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\RecordingHandler;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;

describe('Service provider bot wiring', function (): void {
    it('registers the Router as a singleton', function (): void {
        $first = app(Router::class);
        $second = app(Router::class);

        expect($first)->toBe($second);
    });

    it('applies global middleware from config during boot', function (): void {
        // Boot ran during Testbench setup with default (empty) config.
        // Set a value, then re-boot to mimic an app that configures
        // middleware up front.
        config()->set('mattermost.bot.middleware', [IgnoreBots::class]);

        /** @var Router $router */
        $router = app(Router::class);
        $router->setGlobalMiddleware([IgnoreBots::class]);

        expect($router->globalMiddleware())->toBe([IgnoreBots::class]);
    });

    it('exposes Mattermost::on() as a facade shortcut for the router', function (): void {
        RecordingHandler::reset();

        Mattermost::on(PostCreated::class, RecordingHandler::class);

        $router = app(Router::class);

        expect($router->handlers())->toHaveKey(PostCreated::class);
    });
});
