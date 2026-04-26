<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\AdminOnly;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Saloon\Http\Faking\MockResponse;

function adminPost(string $userId): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => 'p1',
                'channel_id' => 'c1',
                'user_id' => $userId,
            ]),
        ],
        broadcast: ['channel_id' => 'c1'],
        seq: 1,
    );
}

describe('AdminOnly', function (): void {
    it('allows admins through', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'admin-1', 'roles' => 'system_user system_admin']),
        ]);

        $mw = new AdminOnly($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(adminPost('admin-1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('blocks non-admin users', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'user-1', 'roles' => 'system_user']),
        ]);

        $mw = new AdminOnly($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(adminPost('user-1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('caches admin status to avoid repeat lookups', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'admin-1', 'roles' => 'team_admin']),
        ]);

        $cache = new Repository(new ArrayStore);
        $mw = new AdminOnly($fake, $cache);

        $mw->handle(adminPost('admin-1'), fn () => null);
        $mw->handle(adminPost('admin-1'), fn () => null);

        expect($fake->recorded(GetUser::class))->toHaveCount(1);
    });

    it('treats API failures as not-admin', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['error' => 'boom'], 500),
        ]);

        $mw = new AdminOnly($fake, new Repository(new ArrayStore));
        $hit = 0;

        $mw->handle(adminPost('mystery-user'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });
});
