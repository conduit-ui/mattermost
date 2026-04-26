<?php

declare(strict_types=1);

use ConduitUI\Mattermost\MattermostServiceProvider;

describe('config publishing', function (): void {
    it('registers the mattermost-config publish group', function (): void {
        $paths = MattermostServiceProvider::pathsToPublish(
            MattermostServiceProvider::class,
            'mattermost-config',
        );

        expect($paths)->toHaveCount(1);

        $source = array_key_first($paths);
        $destination = $paths[$source];

        expect($source)->toEndWith('config/mattermost.php')
            ->and($destination)->toBe(config_path('mattermost.php'));
    });

    it('maps to an existing config file', function (): void {
        $paths = MattermostServiceProvider::pathsToPublish(
            MattermostServiceProvider::class,
            'mattermost-config',
        );

        $source = array_key_first($paths);

        expect(file_exists($source))->toBeTrue();
    });
});

describe('config keys', function (): void {
    it('provides top-level url key', function (): void {
        expect(config('mattermost.url'))->toBe('http://localhost:8065');
    });

    it('provides top-level token key', function (): void {
        expect(config()->has('mattermost.token'))->toBeTrue();
    });

    it('provides team_id key', function (): void {
        expect(config()->has('mattermost.team_id'))->toBeTrue();
    });

    it('provides bot_user_id key', function (): void {
        expect(config()->has('mattermost.bot_user_id'))->toBeTrue();
    });

    it('provides enable_slash_commands key defaulting to false', function (): void {
        expect(config('mattermost.enable_slash_commands'))->toBeFalse();
    });

    it('provides slash_commands array', function (): void {
        expect(config('mattermost.slash_commands'))->toBeArray();
    });

    it('retains bot middleware config', function (): void {
        expect(config('mattermost.bot.middleware'))->toBeArray();
    });

    it('retains connections config', function (): void {
        expect(config('mattermost.connections.default.url'))->toBe('http://localhost:8065');
    });
});
