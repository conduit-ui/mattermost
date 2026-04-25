<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Filament\Widgets\ConnectionStatusWidget;

describe('ConnectionStatusWidget::formatUptime', function (): void {
    it('returns an em dash when uptime is null', function (): void {
        expect(ConnectionStatusWidget::formatUptime(null))->toBe('—');
    });

    it('formats sub-minute durations in seconds', function (): void {
        expect(ConnectionStatusWidget::formatUptime(0))->toBe('0s')
            ->and(ConnectionStatusWidget::formatUptime(45))->toBe('45s');
    });

    it('formats sub-hour durations in minutes', function (): void {
        expect(ConnectionStatusWidget::formatUptime(60))->toBe('1m')
            ->and(ConnectionStatusWidget::formatUptime(125))->toBe('2m');
    });

    it('formats sub-day durations in hours and minutes', function (): void {
        expect(ConnectionStatusWidget::formatUptime(3600))->toBe('1h')
            ->and(ConnectionStatusWidget::formatUptime(3600 + 12 * 60))->toBe('1h 12m');
    });

    it('formats multi-day durations in days and hours', function (): void {
        expect(ConnectionStatusWidget::formatUptime(86_400))->toBe('1d')
            ->and(ConnectionStatusWidget::formatUptime(86_400 + 5 * 3600))->toBe('1d 5h');
    });
});
