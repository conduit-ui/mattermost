<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\ChannelFilter;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;

function filterPost(string $channelId, string $channelName = ''): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => 'p1',
                'channel_id' => $channelId,
            ]),
            'channel_name' => $channelName,
        ],
        broadcast: ['channel_id' => $channelId],
        seq: 1,
    );
}

describe('ChannelFilter', function (): void {
    it('passes everything through when the allowlist is empty', function (): void {
        config()->set('mattermost.bot.allowed_channels', []);

        $mw = new ChannelFilter;
        $hit = 0;

        $mw->handle(filterPost('chan-x', 'random'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('allows channels matched by id', function (): void {
        config()->set('mattermost.bot.allowed_channels', ['allowed-id']);

        $mw = new ChannelFilter;
        $hit = 0;

        $mw->handle(filterPost('allowed-id', 'foo'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('allows channels matched by name', function (): void {
        config()->set('mattermost.bot.allowed_channels', ['town-square']);

        $mw = new ChannelFilter;
        $hit = 0;

        $mw->handle(filterPost('any-id', 'town-square'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('drops channels not on the allowlist', function (): void {
        config()->set('mattermost.bot.allowed_channels', ['team-only']);

        $mw = new ChannelFilter;
        $hit = 0;

        $mw->handle(filterPost('rando', 'rando'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('passes non-PostCreated events through unconditionally', function (): void {
        config()->set('mattermost.bot.allowed_channels', ['team-only']);

        $mw = new ChannelFilter;
        $hit = 0;

        $mw->handle(new Typing(data: [], broadcast: [], seq: 1), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });
});
