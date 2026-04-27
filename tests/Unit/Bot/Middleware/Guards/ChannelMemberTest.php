<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\Guards\ChannelMember;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMember;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Saloon\Http\Faking\MockResponse;

function memberPost(string $userId, string $channelId = 'c1'): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => 'p1',
                'channel_id' => $channelId,
                'user_id' => $userId,
            ]),
        ],
        broadcast: ['channel_id' => $channelId],
        seq: 1,
    );
}

describe('ChannelMember', function (): void {
    it('allows channel members through', function (): void {
        $fake = Mattermost::fake([
            GetChannelMember::class => MockResponse::make([
                'channel_id' => 'c1',
                'user_id' => 'u1',
                'roles' => 'channel_user',
            ]),
        ]);

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(memberPost('u1', 'c1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('blocks non-members', function (): void {
        $fake = Mattermost::fake([
            GetChannelMember::class => MockResponse::make(
                ['status_code' => 404, 'message' => 'not a member'],
                404,
            ),
        ]);

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(memberPost('u1', 'c1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('caches membership per user+channel pair', function (): void {
        $fake = Mattermost::fake([
            GetChannelMember::class => MockResponse::make([
                'channel_id' => 'c1',
                'user_id' => 'u1',
            ]),
        ]);

        $cache = new Repository(new ArrayStore);
        $mw = new ChannelMember($fake, $cache);

        $mw->handle(memberPost('u1', 'c1'), fn () => null);
        $mw->handle(memberPost('u1', 'c1'), fn () => null);

        expect($fake->recorded(GetChannelMember::class))->toHaveCount(1);
    });

    it('checks separately for different channels', function (): void {
        $fake = Mattermost::fake([
            GetChannelMember::class => MockResponse::make([
                'channel_id' => 'c1',
                'user_id' => 'u1',
            ]),
        ]);

        $cache = new Repository(new ArrayStore);
        $mw = new ChannelMember($fake, $cache);

        $mw->handle(memberPost('u1', 'c1'), fn () => null);
        $mw->handle(memberPost('u1', 'c2'), fn () => null);

        expect($fake->recorded(GetChannelMember::class))->toHaveCount(2);
    });

    it('treats API failures as non-member', function (): void {
        $fake = Mattermost::fake([
            GetChannelMember::class => MockResponse::make(['error' => 'boom'], 500),
        ]);

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(memberPost('u1', 'c1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('passes non-PostCreated events through', function (): void {
        $fake = Mattermost::fake();

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));
        $hit = 0;

        $event = new Typing(data: [], broadcast: [], seq: 1);

        $mw->handle($event, function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('drops events with empty user id', function (): void {
        $fake = Mattermost::fake();

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(memberPost('', 'c1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('drops events with empty channel id', function (): void {
        $fake = Mattermost::fake();

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(memberPost('u1', ''), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('implements the Guard interface', function (): void {
        $fake = Mattermost::fake([
            GetChannelMember::class => MockResponse::make([
                'channel_id' => 'c1',
                'user_id' => 'u1',
            ]),
        ]);

        $mw = new ChannelMember($fake, new Repository(new ArrayStore));

        expect($mw->authorize('u1', 'c1'))->toBeTrue();
    });
});
