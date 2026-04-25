<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Filament;

use ConduitUI\Mattermost\Filament\Pages\Dashboard;
use ConduitUI\Mattermost\Filament\Pages\Health;
use ConduitUI\Mattermost\Filament\Pages\MessageLog;
use ConduitUI\Mattermost\Filament\Widgets\ConnectionStatusWidget;
use Filament\Contracts\Plugin;
use Filament\Panel;

/**
 * Filament plugin that registers the Mattermost dashboard, message log and
 * health pages plus the connection status widget on a target panel.
 *
 * Usage:
 *
 *     $panel->plugin(\ConduitUI\Mattermost\Filament\MattermostPlugin::make());
 *
 * The plugin is opt-in to keep panel registration explicit — pages are NOT
 * auto-discovered onto every installed panel. This avoids surprising operators
 * who have multiple panels.
 */
class MattermostPlugin implements Plugin
{
    public static function make(): self
    {
        return new self;
    }

    public function getId(): string
    {
        return 'mattermost';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->pages([
                Dashboard::class,
                MessageLog::class,
                Health::class,
            ])
            ->widgets([
                ConnectionStatusWidget::class,
            ]);
    }

    public function boot(Panel $panel): void
    {
        // No runtime boot work needed — pages and widgets are stateless and
        // resolve their dependencies via the container at render time.
    }
}
