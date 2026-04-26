<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\Tests\Integration\OriginInjectingConnector;
use ConduitUI\Mattermost\WebSocket\Backoff;
use ConduitUI\Mattermost\WebSocket\Client as WsClient;
use ConduitUI\Mattermost\WebSocket\ConnectionState;
use ConduitUI\Mattermost\WebSocket\Events\Hello;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Psr\Log\NullLogger;
use React\EventLoop\StreamSelectLoop;

describe('WebSocket integration', function (): void {
    it('connects, authenticates, receives Hello, and observes PostCreated for a posted message', function (): void {
        $credentials = $this->credentials();
        $loop = new StreamSelectLoop;

        $client = new WsClient(
            baseUrl: $credentials->baseUrl,
            token: $credentials->botToken,
            logger: new NullLogger,
            loop: $loop,
            // Mattermost validates the WS upgrade's `Origin` header against
            // its SiteURL — without an Origin matching the base URL the
            // server returns 403 with a CORS error. Pawl doesn't set Origin
            // by default, so we wrap the default connector and inject it.
            connector: new OriginInjectingConnector($loop, $credentials->baseUrl),
            backoff: new Backoff,
            // Disable heartbeat fires + make heartbeat timeout effectively
            // infinite for the lifetime of this test — we don't want a
            // ping cycle to influence the assertion timing.
            pingIntervalSeconds: 9999,
            heartbeatTimeoutSeconds: 9999,
            serverEvictionDelaySeconds: 30,
        );

        $marker = 'integration-ws-'.bin2hex(random_bytes(4));

        /** @var array<int, string> $captured */
        $captured = [];
        $sawHello = false;

        $client->on(Hello::class, function () use (&$sawHello): void {
            $sawHello = true;
        });

        $client->on(PostCreated::class, function (PostCreated $event) use ($marker, &$captured, $client): void {
            $message = $event->message();

            if ($message !== '' && str_contains($message, $marker)) {
                $captured[] = $message;
                $client->disconnect();
            }
        });

        // Once we hit Connected (authenticated), trigger the REST post on
        // the next tick so the server has the WS session ready before the
        // event is fanned out. We poll because Connected is reached
        // asynchronously after auth-OK arrives — there's no callback hook
        // for "authenticated" on the Client today.
        $posted = false;
        $pollTimer = $loop->addPeriodicTimer(0.1, function () use ($client, $marker, $loop, &$pollTimer, &$posted): void {
            if ($posted || $client->state() !== ConnectionState::Connected) {
                return;
            }

            $posted = true;

            if ($pollTimer !== null) {
                $loop->cancelTimer($pollTimer);
                $pollTimer = null;
            }

            Mattermost::posts()->createPost(
                channelId: $this->credentials()->channelId,
                message: 'ws-roundtrip '.$marker,
            );
        });

        // Hard ceiling so a hung connect doesn't stall CI.
        $loop->addTimer(10.0, function () use ($client): void {
            $client->disconnect();
        });

        $client->run();

        expect($sawHello)->toBeTrue('server should send the hello frame after auth');
        expect($captured)->not->toBeEmpty('WS feed should have surfaced the posted message');
    });
});
