<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\Dedup;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;

function makeDedup(): Dedup
{
    return new Dedup(new Repository(new ArrayStore));
}

function dedupPost(string $channelId = 'C', string $postId = 'P'): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => $postId,
                'channel_id' => $channelId,
                'message' => 'hi',
            ]),
        ],
        broadcast: ['channel_id' => $channelId],
        seq: 1,
    );
}

describe('Dedup', function (): void {
    it('passes the first occurrence through', function (): void {
        $dedup = makeDedup();
        $invoked = 0;

        $dedup->handle(dedupPost(), function () use (&$invoked): void {
            $invoked++;
        });

        expect($invoked)->toBe(1);
    });

    it('drops a duplicate channel+post', function (): void {
        $dedup = makeDedup();
        $invoked = 0;
        $next = function () use (&$invoked): void {
            $invoked++;
        };

        $dedup->handle(dedupPost(), $next);
        $dedup->handle(dedupPost(), $next);

        expect($invoked)->toBe(1);
    });

    it('treats different posts independently', function (): void {
        $dedup = makeDedup();
        $invoked = 0;
        $next = function () use (&$invoked): void {
            $invoked++;
        };

        $dedup->handle(dedupPost(postId: 'a'), $next);
        $dedup->handle(dedupPost(postId: 'b'), $next);

        expect($invoked)->toBe(2);
    });

    it('always passes through non-PostCreated events', function (): void {
        $dedup = makeDedup();
        $invoked = 0;
        $next = function () use (&$invoked): void {
            $invoked++;
        };

        $event = new Typing(data: [], broadcast: [], seq: 1);

        $dedup->handle($event, $next);
        $dedup->handle($event, $next);

        expect($invoked)->toBe(2);
    });
});
