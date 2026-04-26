<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\HandleEventJob;
use ConduitUI\Mattermost\Bot\Router;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\HandlerWithMiddleware;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\QueuedHandler;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\RecordingHandler;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\SecondRecordingHandler;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\ShortCircuitMiddleware;
use ConduitUI\Mattermost\Tests\Unit\Bot\Doubles\TaggingMiddleware;
use ConduitUI\Mattermost\WebSocket\Events\GenericEvent;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;

beforeEach(function (): void {
    RecordingHandler::reset();
    SecondRecordingHandler::reset();
    QueuedHandler::reset();
    HandlerWithMiddleware::reset();
    TaggingMiddleware::reset();
});

function makePostCreated(string $channelId = 'chan-1', string $postId = 'post-1', string $userId = 'user-1'): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => $postId,
                'channel_id' => $channelId,
                'user_id' => $userId,
                'message' => 'hi',
                'root_id' => '',
            ]),
            'channel_type' => 'O',
            'channel_name' => 'town-square',
            'sender_name' => '@alice',
        ],
        broadcast: ['channel_id' => $channelId],
        seq: 1,
    );
}

describe('Router', function (): void {
    it('dispatches to a handler registered by event class', function (): void {
        $router = app(Router::class);
        $router->on(PostCreated::class, RecordingHandler::class);

        $router->dispatch(makePostCreated());

        expect(RecordingHandler::$invocations)->toHaveCount(1);
    });

    it('supports multiple handlers per event type', function (): void {
        $router = app(Router::class);
        $router->on(PostCreated::class, RecordingHandler::class);
        $router->on(PostCreated::class, SecondRecordingHandler::class);

        $router->dispatch(makePostCreated());

        expect(RecordingHandler::$invocations)->toHaveCount(1)
            ->and(SecondRecordingHandler::$invocations)->toHaveCount(1);
    });

    it('routes wildcard handlers for any event', function (): void {
        $router = app(Router::class);
        $router->on('*', RecordingHandler::class);

        $router->dispatch(makePostCreated());
        $router->dispatch(new Typing(data: [], broadcast: ['channel_id' => 'x'], seq: 2));

        expect(RecordingHandler::$invocations)->toHaveCount(2);
    });

    it('routes by Mattermost event-name string', function (): void {
        $router = app(Router::class);
        $router->on('posted', RecordingHandler::class);

        $router->dispatch(makePostCreated());

        expect(RecordingHandler::$invocations)->toHaveCount(1);
    });

    it('routes generic events by their underlying name', function (): void {
        $router = app(Router::class);
        $router->on('something_custom', RecordingHandler::class);

        $event = new GenericEvent('something_custom', [], [], 1);
        $router->dispatch($event);

        expect(RecordingHandler::$invocations)->toHaveCount(1)
            ->and(RecordingHandler::$invocations[0])->toBe($event);
    });

    it('does not invoke handlers when no registration matches', function (): void {
        $router = app(Router::class);
        $router->on(Typing::class, RecordingHandler::class);

        $router->dispatch(makePostCreated());

        expect(RecordingHandler::$invocations)->toBeEmpty();
    });

    it('runs global middleware in registration order', function (): void {
        $router = app(Router::class);
        $router->setGlobalMiddleware([TaggingMiddleware::class]);
        $router->on(PostCreated::class, RecordingHandler::class);

        $router->dispatch(makePostCreated());

        expect(RecordingHandler::$invocations)->toHaveCount(1)
            ->and(TaggingMiddleware::$tags)->toBe(['before', 'after']);
    });

    it('lets middleware short-circuit by not calling next', function (): void {
        $router = app(Router::class);
        $router->setGlobalMiddleware([ShortCircuitMiddleware::class]);
        $router->on(PostCreated::class, RecordingHandler::class);

        $router->dispatch(makePostCreated());

        expect(RecordingHandler::$invocations)->toBeEmpty();
    });

    it('reads per-handler middleware from the #[Middleware] attribute', function (): void {
        $router = app(Router::class);
        $router->on(PostCreated::class, HandlerWithMiddleware::class);

        $router->dispatch(makePostCreated());

        expect(HandlerWithMiddleware::$invocations)->toHaveCount(1)
            ->and(TaggingMiddleware::$tags)->toBe(['before', 'after']);
    });

    it('appends per-handler middleware after global middleware', function (): void {
        $router = app(Router::class);
        $router->setGlobalMiddleware([ShortCircuitMiddleware::class]);
        $router->on(PostCreated::class, HandlerWithMiddleware::class);

        $router->dispatch(makePostCreated());

        // Global short-circuit fires first → handler-specific middleware
        // never even runs.
        expect(HandlerWithMiddleware::$invocations)->toBeEmpty()
            ->and(TaggingMiddleware::$tags)->toBeEmpty();
    });

    it('fires every event as a Laravel event', function (): void {
        Event::fake([PostCreated::class]);

        $router = app(Router::class);
        $event = makePostCreated();

        $router->dispatch($event);

        Event::assertDispatched(PostCreated::class);
    });

    it('dispatches ShouldQueue handlers onto the bus', function (): void {
        Bus::fake();

        $router = app(Router::class);
        $router->on(PostCreated::class, QueuedHandler::class);

        $router->dispatch(makePostCreated(postId: 'queued-post'));

        Bus::assertDispatched(HandleEventJob::class, fn (HandleEventJob $job): bool => $job->handlerClass === QueuedHandler::class);

        // Synchronous handle() should NOT have run.
        expect(QueuedHandler::$invocations)->toBeEmpty();
    });
});
