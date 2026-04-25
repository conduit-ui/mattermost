<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Filament\Stats\MattermostStats;
use ConduitUI\Mattermost\WebSocket\ConnectionState;
use Illuminate\Cache\ArrayStore;
use Illuminate\Cache\Repository;

function makeStats(string $connection = 'default'): MattermostStats
{
    return new MattermostStats(new Repository(new ArrayStore), $connection);
}

describe('MattermostStats', function (): void {
    it('defaults to disconnected when no state has been written', function (): void {
        expect(makeStats()->connectionState())->toBe(ConnectionState::Disconnected);
    });

    it('round-trips connection state through cache', function (): void {
        $stats = makeStats();

        $stats->setConnectionState(ConnectionState::Connected);

        expect($stats->connectionState())->toBe(ConnectionState::Connected);
    });

    it('exposes mark helpers for the common transitions', function (): void {
        $stats = makeStats();

        $stats->markConnected();
        expect($stats->connectionState())->toBe(ConnectionState::Connected);

        $stats->markReconnecting();
        expect($stats->connectionState())->toBe(ConnectionState::Reconnecting);

        $stats->markDisconnected();
        expect($stats->connectionState())->toBe(ConnectionState::Disconnected);
    });

    it('tracks uptime relative to markStarted timestamp', function (): void {
        $stats = makeStats();

        expect($stats->uptimeSeconds())->toBeNull();

        $stats->markStarted(time() - 90);

        expect($stats->uptimeSeconds())->toBeGreaterThanOrEqual(90)
            ->and($stats->uptimeSeconds())->toBeLessThan(120);
    });

    it('increments and reads the messages-processed counter', function (): void {
        $stats = makeStats();

        expect($stats->messagesProcessed())->toBe(0);

        $stats->incrementMessagesProcessed();
        $stats->incrementMessagesProcessed(4);

        expect($stats->messagesProcessed())->toBe(5);
    });

    it('isolates state per connection name', function (): void {
        $shared = new Repository(new ArrayStore);
        $a = new MattermostStats($shared, 'a');
        $b = new MattermostStats($shared, 'b');

        $a->markConnected();
        $a->incrementMessagesProcessed(3);

        expect($b->connectionState())->toBe(ConnectionState::Disconnected)
            ->and($b->messagesProcessed())->toBe(0)
            ->and($a->connectionState())->toBe(ConnectionState::Connected)
            ->and($a->messagesProcessed())->toBe(3);
    });

    it('clears all keys via reset', function (): void {
        $stats = makeStats();

        $stats->markConnected();
        $stats->markStarted();
        $stats->incrementMessagesProcessed(10);

        $stats->reset();

        expect($stats->connectionState())->toBe(ConnectionState::Disconnected)
            ->and($stats->startedAt())->toBeNull()
            ->and($stats->messagesProcessed())->toBe(0);
    });
});
