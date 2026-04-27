<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Interactive\InteractiveAction;
use ConduitUI\Mattermost\Interactive\InteractiveActionHandler;
use ConduitUI\Mattermost\Interactive\InteractiveActionResponse;
use ConduitUI\Mattermost\Interactive\InteractiveActionRouter;
use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('InteractiveActionRouter', function (): void {
    it('dispatches to a registered class-based handler', function (): void {
        $router = app(InteractiveActionRouter::class);
        $router->register('approve', StubApproveHandler::class);

        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));
        $response = $router->dispatch($action);

        expect($response)->not->toBeNull()
            ->and($response->toArray())->toHaveKey('update')
            ->and($response->toArray()['update']['message'])->toBe('Request approved');
    });

    it('dispatches to a registered closure handler', function (): void {
        $router = app(InteractiveActionRouter::class);
        $router->register('deny', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make()->ephemeral('Denied'));

        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('deny'));
        $response = $router->dispatch($action);

        expect($response)->not->toBeNull()
            ->and($response->toArray()['ephemeral_text'])->toBe('Denied');
    });

    it('returns null for unregistered actions', function (): void {
        $router = app(InteractiveActionRouter::class);

        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('unknown'));

        expect($router->dispatch($action))->toBeNull();
    });

    it('checks handler registration via hasHandler', function (): void {
        $router = app(InteractiveActionRouter::class);
        $router->register('approve', StubApproveHandler::class);

        expect($router->hasHandler('approve'))->toBeTrue()
            ->and($router->hasHandler('unknown'))->toBeFalse();
    });

    it('returns all registered handlers', function (): void {
        $router = app(InteractiveActionRouter::class);
        $router->register('approve', StubApproveHandler::class);
        $router->register('deny', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make());

        expect($router->handlers())->toHaveCount(2)
            ->and($router->handlers())->toHaveKeys(['approve', 'deny']);
    });

    it('allows overwriting a previously registered handler', function (): void {
        $router = app(InteractiveActionRouter::class);
        $router->register('approve', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make()->ephemeral('v1'));
        $router->register('approve', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make()->ephemeral('v2'));

        $action = InteractiveAction::fromPayload(MattermostFixtures::fakeButtonClick('approve'));
        $response = $router->dispatch($action);

        expect($response->toArray()['ephemeral_text'])->toBe('v2');
    });

    it('is chainable via register', function (): void {
        $router = app(InteractiveActionRouter::class);

        $result = $router
            ->register('a', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make())
            ->register('b', fn (InteractiveAction $a): InteractiveActionResponse => InteractiveActionResponse::make());

        expect($result)->toBeInstanceOf(InteractiveActionRouter::class)
            ->and($router->handlers())->toHaveCount(2);
    });
});

// --- Stub handler for testing ---

class StubApproveHandler extends InteractiveActionHandler
{
    #[Override]
    public function handle(InteractiveAction $action): InteractiveActionResponse
    {
        return InteractiveActionResponse::make()->update('Request approved');
    }
}
