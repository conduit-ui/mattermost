<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Filament\Pages;

use BackedEnum;
use ConduitUI\Mattermost\Filament\Widgets\ConnectionStatusWidget;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetConfiguration;

/**
 * Top-level Mattermost dashboard. Hosts the {@see ConnectionStatusWidget}
 * in the header so panel users see connection / uptime / volume at a glance
 * without depending on Filament's built-in dashboard slot.
 */
class Dashboard extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Bolt;

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Mattermost';

    protected static ?int $navigationSort = 10;

    protected string $view = 'mattermost::filament.pages.dashboard';

    /**
     * @return array<int, class-string<Widget> | WidgetConfiguration>
     */
    #[\Override]
    public function getHeaderWidgets(): array
    {
        return [
            ConnectionStatusWidget::class,
        ];
    }

    #[\Override]
    public function getHeaderWidgetsColumns(): int|array
    {
        return 4;
    }
}
