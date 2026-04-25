<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Filament\Stats\MattermostStats;
use ConduitUI\Mattermost\WebSocket\ConnectionState;

describe('MattermostServiceProvider Filament boot', function (): void {
    it('boots cleanly even when Filament views are loaded', function (): void {
        // Provider is already booted by the test harness; just assert no
        // errors were thrown and the singleton stats binding is wired up.
        expect(app(MattermostStats::class))->toBeInstanceOf(MattermostStats::class);
    });

    it('binds MattermostStats as a singleton', function (): void {
        expect(app(MattermostStats::class))->toBe(app(MattermostStats::class));
    });

    it('exposes a working stats writer that survives across resolutions', function (): void {
        $stats = app(MattermostStats::class);
        $stats->markConnected();

        expect(app(MattermostStats::class)->connectionState())->toBe(ConnectionState::Connected);
    });

    it('reads the connection name from config when constructing stats', function (): void {
        // Default test config sets mattermost.default = 'default'
        expect(app(MattermostStats::class)->connection())->toBe('default');
    });
});
