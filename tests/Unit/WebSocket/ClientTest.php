<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles\FakeConnector;
use ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles\FakeWebSocket;
use ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles\RecordingLogger;
use ConduitUI\Mattermost\WebSocket\Backoff;
use ConduitUI\Mattermost\WebSocket\Client;
use ConduitUI\Mattermost\WebSocket\ConnectionState;
use ConduitUI\Mattermost\WebSocket\Events\Hello;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use React\EventLoop\StreamSelectLoop;

/**
 * Drive the Client's lifecycle in-process by injecting a real ReactPHP
 * loop together with our `FakeConnector` + `FakeWebSocket`.
 *
 * Each test arranges the connector behaviour, runs the client briefly,
 * then asserts on what was sent / what state we ended in. The loop is
 * stopped by `$client->disconnect()` from a deferred callback so we
 * never actually wait in real time.
 */
function makeClient(
    StreamSelectLoop $loop,
    FakeConnector $connector,
    RecordingLogger $logger,
    int $heartbeatTimeout = 9999,
    ?Backoff $backoff = null,
): Client {
    return new Client(
        baseUrl: 'http://localhost:8065',
        token: 'test-token',
        logger: $logger,
        loop: $loop,
        connector: $connector,
        backoff: $backoff,
        pingIntervalSeconds: 9999, // disable heartbeat fires during tests
        heartbeatTimeoutSeconds: $heartbeatTimeout,
        serverEvictionDelaySeconds: 30,
    );
}

describe('Client', function (): void {
    it('builds the ws URL by transforming the connector base URL', function (): void {
        $loop = new StreamSelectLoop;
        $connector = new FakeConnector;
        $client = makeClient($loop, $connector, new RecordingLogger);

        expect($client->url())->toBe('ws://localhost:8065/api/v4/websocket');
    });

    it('starts in disconnected state', function (): void {
        $loop = new StreamSelectLoop;
        $client = makeClient($loop, new FakeConnector, new RecordingLogger);

        expect($client->state())->toBe(ConnectionState::Disconnected);
    });

    it('sends the auth challenge frame on open and dispatches the auth-OK reply', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);
        $logger = new RecordingLogger;
        $client = makeClient($loop, $connector, $logger);

        // After the auth-OK reply we'll be in Connected state — exit
        // the loop from a wildcard listener (none fires for status:OK)
        // so instead schedule a future-tick that pushes a frame in,
        // then disconnects.
        $loop->addTimer(0.001, function () use ($socket): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
        });
        $loop->addTimer(0.01, fn () => $client->disconnect());

        $client->run();

        expect($connector->calls)->toBe(['ws://localhost:8065/api/v4/websocket']);
        expect($socket->sent)->toHaveCount(1);

        $authFrame = json_decode($socket->sent[0], true);
        expect($authFrame)->toBe([
            'seq' => 1,
            'action' => 'authentication_challenge',
            'data' => ['token' => 'test-token'],
        ]);

        expect($logger->has('Mattermost WS authenticated'))->toBeTrue();
    });

    it('dispatches typed events to listeners registered by class name', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);
        $client = makeClient($loop, $connector, new RecordingLogger);

        $captured = [];
        $client->on(PostCreated::class, function (PostCreated $event) use (&$captured): void {
            $captured[] = $event;
        });

        $loop->addTimer(0.001, function () use ($socket): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
            $socket->emitMessage(json_encode([
                'event' => 'posted',
                'data' => [
                    'channel_type' => 'D',
                    'channel_name' => 'lexi__jordan',
                    'sender_name' => '@jordan',
                    'post' => json_encode(['id' => 'p1', 'channel_id' => 'c1', 'user_id' => 'u1', 'message' => 'hi']),
                ],
                'broadcast' => ['channel_id' => 'c1'],
                'seq' => 7,
            ]));
        });
        $loop->addTimer(0.01, fn () => $client->disconnect());

        $client->run();

        expect($captured)->toHaveCount(1);
        expect($captured[0])->toBeInstanceOf(PostCreated::class);
        expect($captured[0]->message())->toBe('hi');
    });

    it('dispatches all events to wildcard listeners', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);
        $client = makeClient($loop, $connector, new RecordingLogger);

        $names = [];
        $client->onAny(function ($event) use (&$names): void {
            $names[] = $event->name();
        });

        $loop->addTimer(0.001, function () use ($socket): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
            $socket->emitMessage(json_encode([
                'event' => 'hello',
                'data' => ['server_version' => '9.5.0'],
                'broadcast' => [],
                'seq' => 1,
            ]));
            $socket->emitMessage(json_encode([
                'event' => 'typing',
                'data' => ['user_id' => 'u1'],
                'broadcast' => ['channel_id' => 'c1'],
                'seq' => 2,
            ]));
        });
        $loop->addTimer(0.01, fn () => $client->disconnect());

        $client->run();

        expect($names)->toBe(['hello', 'typing']);
    });

    it('logs but does not crash when a listener throws', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);
        $logger = new RecordingLogger;
        $client = makeClient($loop, $connector, $logger);

        $client->on(Hello::class, function (): void {
            throw new RuntimeException('boom');
        });

        $loop->addTimer(0.001, function () use ($socket): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
            $socket->emitMessage(json_encode([
                'event' => 'hello',
                'data' => ['server_version' => '9.5.0'],
                'broadcast' => [],
                'seq' => 0,
            ]));
        });
        $loop->addTimer(0.01, fn () => $client->disconnect());

        $client->run();

        expect($logger->has('listener threw'))->toBeTrue();
    });

    it('schedules a reconnect with exponential backoff on connect failure', function (): void {
        $loop = new StreamSelectLoop;
        $connector = new FakeConnector;

        $attempts = 0;
        $connector->setBehaviour(function (int $attempt, $deferred) use (&$attempts): void {
            $attempts = $attempt;
            $deferred->reject(new RuntimeException('refused'));
        });
        $logger = new RecordingLogger;

        $backoff = new Backoff(initial: 1, max: 60);
        $client = makeClient($loop, $connector, $logger, backoff: $backoff);

        // Stop the loop after a brief wall-clock window — we just want
        // to see the FIRST connect attempt fail and a retry to be
        // scheduled (we don't wait for the 1s retry to actually fire).
        $loop->addTimer(0.01, fn () => $client->disconnect());
        $client->run();

        expect($attempts)->toBe(1);
        expect($logger->has('connect failed'))->toBeTrue();
        // Backoff advanced from 1 → next would be 2.
        expect($backoff->current())->toBe(2);
    });

    it('reconnects on unexpected close', function (): void {
        $loop = new StreamSelectLoop;
        $sockets = [new FakeWebSocket, new FakeWebSocket];
        $connector = new FakeConnector;
        $connector->setBehaviour(function (int $attempt, $deferred) use ($sockets): void {
            $deferred->resolve($sockets[$attempt - 1] ?? new FakeWebSocket);
        });
        $logger = new RecordingLogger;

        $backoff = new Backoff(initial: 1, max: 1); // immediate retry
        $client = makeClient($loop, $connector, $logger, backoff: $backoff);

        $loop->addTimer(0.001, function () use ($sockets): void {
            // Auth the first socket then trigger a server close.
            $sockets[0]->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
            $sockets[0]->close(1006, 'abnormal');
        });
        // Allow up to 2.5s wall clock for the second connection
        // (backoff is 1s).
        $loop->addTimer(2.5, fn () => $client->disconnect());

        $client->run();

        expect($connector->calls)->toHaveCount(2);
        expect($logger->has('Mattermost WS closed'))->toBeTrue();
    });

    it('uses an extended delay on server-initiated 1000 close', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);
        $logger = new RecordingLogger;

        $client = makeClient($loop, $connector, $logger);

        $loop->addTimer(0.001, function () use ($socket): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
            // server kicks us with normal close → eviction delay
            $socket->close(1000, 'duplicate session');
        });
        $loop->addTimer(0.01, fn () => $client->disconnect());

        $client->run();

        expect($logger->has('extended backoff'))->toBeTrue();
    });

    it('does not reconnect after disconnect()', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);

        $client = makeClient($loop, $connector, new RecordingLogger);

        $loop->addTimer(0.001, function () use ($socket, $client): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
            $client->disconnect();
        });
        // Hard timeout safeguard.
        $loop->addTimer(0.5, fn () => $client->disconnect());

        $client->run();

        expect($client->state())->toBe(ConnectionState::Disconnected);
        expect($connector->calls)->toHaveCount(1);
    });

    it('logs every state change', function (): void {
        $loop = new StreamSelectLoop;
        $socket = new FakeWebSocket;
        $connector = new FakeConnector;
        $connector->alwaysResolveWith($socket);
        $logger = new RecordingLogger;

        $client = makeClient($loop, $connector, $logger);

        $loop->addTimer(0.001, function () use ($socket): void {
            $socket->emitMessage(json_encode(['status' => 'OK', 'seq_reply' => 1]));
        });
        $loop->addTimer(0.01, fn () => $client->disconnect());

        $client->run();

        $stateChanges = array_filter(
            $logger->records,
            fn ($r) => $r['message'] === 'Mattermost WS state change'
        );
        expect(count($stateChanges))->toBeGreaterThan(0);
    });
});
