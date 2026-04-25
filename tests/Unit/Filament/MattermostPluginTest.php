<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Filament\MattermostPlugin;

describe('MattermostPlugin', function (): void {
    it('exposes a stable plugin id', function (): void {
        expect(MattermostPlugin::make()->getId())->toBe('mattermost');
    });

    it('is constructible via static make()', function (): void {
        expect(MattermostPlugin::make())->toBeInstanceOf(MattermostPlugin::class);
    });
});
