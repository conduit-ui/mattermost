<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Filament\Widgets;

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Filament\Stats\MattermostStats;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\WebSocket\ConnectionState;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Throwable;

/**
 * Dashboard widget summarising connection status, bot identity,
 * uptime and messages processed.
 *
 * Reads from the cache-backed {@see MattermostStats} for runtime metrics
 * (populated by the WS client / bot framework) and from the Saloon API
 * for bot user info. API calls are best-effort and never throw — the widget
 * stays usable when the server is unreachable.
 */
class ConnectionStatusWidget extends StatsOverviewWidget
{
    protected ?string $heading = 'Mattermost bot';

    /**
     * @return array<int, Stat>
     */
    #[\Override]
    protected function getStats(): array
    {
        $stats = $this->mattermostStats();

        return [
            $this->buildConnectionStat($stats->connectionState()),
            $this->buildBotIdentityStat(),
            $this->buildUptimeStat($stats->uptimeSeconds()),
            $this->buildMessagesProcessedStat($stats->messagesProcessed()),
        ];
    }

    private function buildConnectionStat(ConnectionState $state): Stat
    {
        return Stat::make('Connection', ucfirst($state->value))
            ->description($this->descriptionForState($state))
            ->descriptionIcon($this->iconForState($state))
            ->color($this->colorForState($state));
    }

    private function buildBotIdentityStat(): Stat
    {
        $username = '—';
        $description = 'Bot identity unavailable';

        try {
            $response = $this->mattermost()->users()->getUser('me');

            if ($response->successful()) {
                /** @var array<string, mixed> $data */
                $data = $response->json();
                $username = is_string($data['username'] ?? null) ? '@'.$data['username'] : '—';
                $description = is_string($data['id'] ?? null) ? $data['id'] : 'Bot identity unavailable';
            }
        } catch (Throwable) {
            // Best-effort: server may be unreachable. Leave defaults.
        }

        return Stat::make('Bot user', $username)
            ->description($description)
            ->descriptionIcon(Heroicon::User)
            ->color('gray');
    }

    private function buildUptimeStat(?int $seconds): Stat
    {
        return Stat::make('Uptime', self::formatUptime($seconds))
            ->description($seconds === null ? 'Listener has not booted' : 'Since last restart')
            ->descriptionIcon(Heroicon::Clock)
            ->color($seconds === null ? 'gray' : 'success');
    }

    private function buildMessagesProcessedStat(int $count): Stat
    {
        return Stat::make('Messages processed', number_format($count))
            ->description('Since last restart')
            ->descriptionIcon(Heroicon::ChatBubbleBottomCenterText)
            ->color('info');
    }

    private function mattermostStats(): MattermostStats
    {
        return app(MattermostStats::class);
    }

    private function mattermost(): Mattermost
    {
        return app(MattermostManager::class)->connection();
    }

    public static function formatUptime(?int $seconds): string
    {
        if ($seconds === null) {
            return '—';
        }

        if ($seconds < 60) {
            return $seconds.'s';
        }

        $minutes = intdiv($seconds, 60);

        if ($minutes < 60) {
            return $minutes.'m';
        }

        $hours = intdiv($minutes, 60);
        $remainingMinutes = $minutes % 60;

        if ($hours < 24) {
            return $remainingMinutes > 0
                ? sprintf('%dh %dm', $hours, $remainingMinutes)
                : sprintf('%dh', $hours);
        }

        $days = intdiv($hours, 24);
        $remainingHours = $hours % 24;

        return $remainingHours > 0
            ? sprintf('%dd %dh', $days, $remainingHours)
            : sprintf('%dd', $days);
    }

    private function descriptionForState(ConnectionState $state): string
    {
        return match ($state) {
            ConnectionState::Connected => 'Live WebSocket session',
            ConnectionState::Connecting => 'Negotiating connection',
            ConnectionState::Authenticating => 'Authenticating bot token',
            ConnectionState::Reconnecting => 'Recovering after drop',
            ConnectionState::Closing => 'Closing connection',
            ConnectionState::Disconnected => 'No active session',
        };
    }

    private function colorForState(ConnectionState $state): string
    {
        return match ($state) {
            ConnectionState::Connected => 'success',
            ConnectionState::Connecting, ConnectionState::Authenticating, ConnectionState::Reconnecting => 'warning',
            ConnectionState::Closing, ConnectionState::Disconnected => 'danger',
        };
    }

    private function iconForState(ConnectionState $state): Heroicon
    {
        return match ($state) {
            ConnectionState::Connected => Heroicon::CheckCircle,
            ConnectionState::Connecting, ConnectionState::Authenticating, ConnectionState::Reconnecting => Heroicon::ArrowPath,
            ConnectionState::Closing, ConnectionState::Disconnected => Heroicon::XCircle,
        };
    }
}
