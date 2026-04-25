<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Filament\Pages\MessageLog;

describe('MessageLog page', function (): void {
    it('returns null watch channel when no config is set', function (): void {
        config()->set('mattermost.filament.watch_channel_id', null);

        expect(MessageLog::defaultChannelId())->toBeNull();
    });

    it('returns the configured watch channel id', function (): void {
        config()->set('mattermost.filament.watch_channel_id', 'chan-abc');

        expect(MessageLog::defaultChannelId())->toBe('chan-abc');
    });

    it('returns null when the configured channel id is an empty string', function (): void {
        config()->set('mattermost.filament.watch_channel_id', '');

        expect(MessageLog::defaultChannelId())->toBeNull();
    });
});
