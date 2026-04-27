<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\Guards\RequiresRole;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Saloon\Http\Faking\MockResponse;

function guardPost(string $userId, string $channelId = 'c1'): PostCreated
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

describe('RequiresRole', function (): void {
    it('allows users with the required role', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_user system_admin']),
        ]);

        $mw = new RequiresRole($fake, new Repository(new ArrayStore), 'system_admin');
        $hit = 0;

        $mw->handle(guardPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('blocks users without the required role', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_user']),
        ]);

        $mw = new RequiresRole($fake, new Repository(new ArrayStore), 'system_admin');
        $hit = 0;

        $mw->handle(guardPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('caches role lookups per user', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_admin']),
        ]);

        $cache = new Repository(new ArrayStore);
        $mw = new RequiresRole($fake, $cache, 'system_admin');

        $mw->handle(guardPost('u1'), fn () => null);
        $mw->handle(guardPost('u1'), fn () => null);

        expect($fake->recorded(GetUser::class))->toHaveCount(1);
    });

    it('treats API failures as unauthorized', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['error' => 'boom'], 500),
        ]);

        $mw = new RequiresRole($fake, new Repository(new ArrayStore), 'system_admin');
        $hit = 0;

        $mw->handle(guardPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('passes non-PostCreated events through', function (): void {
        $fake = Mattermost::fake();

        $mw = new RequiresRole($fake, new Repository(new ArrayStore), 'system_admin');
        $hit = 0;

        $event = new Typing(data: [], broadcast: [], seq: 1);

        $mw->handle($event, function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('drops events with empty user id', function (): void {
        $fake = Mattermost::fake();

        $mw = new RequiresRole($fake, new Repository(new ArrayStore), 'system_admin');
        $hit = 0;

        $mw->handle(guardPost(''), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('implements the Guard interface', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_admin']),
        ]);

        $mw = new RequiresRole($fake, new Repository(new ArrayStore), 'system_admin');

        expect($mw->authorize('u1', 'c1'))->toBeTrue();
    });
});
