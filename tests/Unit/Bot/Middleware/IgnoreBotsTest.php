<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\IgnoreBots;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;

/**
 * @param  array<string, mixed>  $extra
 */
function botPost(string $userId = 'human-user', array $extra = []): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode(array_merge([
                'id' => 'p1',
                'channel_id' => 'c1',
                'user_id' => $userId,
                'message' => 'hi',
            ], $extra)),
        ],
        broadcast: ['channel_id' => 'c1'],
        seq: 1,
    );
}

describe('IgnoreBots', function (): void {
    it('passes through human-authored posts', function (): void {
        $mw = new IgnoreBots;
        $hit = 0;

        $mw->handle(botPost('human-1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('drops posts authored by the configured bot user', function (): void {
        $mw = new IgnoreBots;
        $hit = 0;

        $mw->handle(botPost('bot-user-id'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('drops posts marked from_bot', function (): void {
        $mw = new IgnoreBots;
        $hit = 0;

        $mw->handle(botPost('some-other-bot', ['props' => ['from_bot' => true]]), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('treats from_bot=true string as truthy', function (): void {
        $mw = new IgnoreBots;
        $hit = 0;

        $mw->handle(botPost('x', ['props' => ['from_bot' => 'true']]), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('passes through non-PostCreated events', function (): void {
        $mw = new IgnoreBots;
        $hit = 0;

        $event = new Typing(data: [], broadcast: [], seq: 1);

        $mw->handle($event, function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });
});
