<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Middleware\Guards\RequiresPermission;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\Typing;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;
use Saloon\Http\Faking\MockResponse;

function permissionPost(string $userId, string $channelId = 'c1'): PostCreated
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

describe('RequiresPermission', function (): void {
    it('allows users with a role that grants the permission', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_user team_admin']),
        ]);

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'manage_team');
        $hit = 0;

        $mw->handle(permissionPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('blocks users without a role that grants the permission', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_user']),
        ]);

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'manage_team');
        $hit = 0;

        $mw->handle(permissionPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('allows system_admin for manage_system permission', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_user system_admin']),
        ]);

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'manage_system');
        $hit = 0;

        $mw->handle(permissionPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('denies unknown permissions', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_admin']),
        ]);

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'nonexistent_perm');
        $hit = 0;

        $mw->handle(permissionPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('caches permission lookups per user', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'team_admin']),
        ]);

        $cache = new Repository(new ArrayStore);
        $mw = new RequiresPermission($fake, $cache, 'manage_team');

        $mw->handle(permissionPost('u1'), fn () => null);
        $mw->handle(permissionPost('u1'), fn () => null);

        expect($fake->recorded(GetUser::class))->toHaveCount(1);
    });

    it('treats API failures as unauthorized', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['error' => 'boom'], 500),
        ]);

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'manage_team');
        $hit = 0;

        $mw->handle(permissionPost('u1'), function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(0);
    });

    it('passes non-PostCreated events through', function (): void {
        $fake = Mattermost::fake();

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'manage_team');
        $hit = 0;

        $event = new Typing(data: [], broadcast: [], seq: 1);

        $mw->handle($event, function () use (&$hit): void {
            $hit++;
        });

        expect($hit)->toBe(1);
    });

    it('implements the Guard interface', function (): void {
        $fake = Mattermost::fake([
            GetUser::class => MockResponse::make(['id' => 'u1', 'roles' => 'system_admin']),
        ]);

        $mw = new RequiresPermission($fake, new Repository(new ArrayStore), 'manage_system');

        expect($mw->authorize('u1', 'c1'))->toBeTrue();
    });
});
