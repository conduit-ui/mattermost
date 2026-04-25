<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\RateLimit;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;

function makeRateLimit(): RateLimit
{
    return new RateLimit(new Repository(new ArrayStore));
}

function ratePost(string $channelId, string $type = 'O', string $postId = 'p'): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => $postId,
                'channel_id' => $channelId,
            ]),
            'channel_type' => $type,
        ],
        broadcast: ['channel_id' => $channelId],
        seq: 1,
    );
}

describe('RateLimit', function (): void {
    it('allows the first event for a channel through', function (): void {
        $rl = makeRateLimit();
        $hit = 0;

        $rl->handle(ratePost('chan-1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('blocks subsequent events within the cooldown', function (): void {
        $rl = makeRateLimit();
        $hit = 0;
        $next = function () use (&$hit): void {
            $hit++;
        };

        $rl->handle(ratePost('chan-1', postId: 'a'), $next);
        $rl->handle(ratePost('chan-1', postId: 'b'), $next);

        expect($hit)->toBe(1);
    });

    it('treats DM channels (type=D) as exempt', function (): void {
        $rl = makeRateLimit();
        $hit = 0;
        $next = function () use (&$hit): void {
            $hit++;
        };

        $rl->handle(ratePost('chan-dm', type: 'D', postId: 'a'), $next);
        $rl->handle(ratePost('chan-dm', type: 'D', postId: 'b'), $next);

        expect($hit)->toBe(2);
    });

    it('isolates cooldowns per channel', function (): void {
        $rl = makeRateLimit();
        $hit = 0;
        $next = function () use (&$hit): void {
            $hit++;
        };

        $rl->handle(ratePost('chan-a', postId: '1'), $next);
        $rl->handle(ratePost('chan-b', postId: '2'), $next);

        expect($hit)->toBe(2);
    });
});
