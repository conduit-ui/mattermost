<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Filament\Pages;

use BackedEnum;
use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Filament\Stats\MattermostStats;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\WebSocket\ConnectionState;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Throwable;

/**
 * Live health snapshot for an operator: API reachability + latency, the
 * WebSocket lifecycle state from {@see MattermostStats}, and a quick
 * channel-membership listing for the bot user.
 *
 * Every probe is wrapped in try/catch — when the server is offline the
 * page still renders, just with red "unreachable" rows.
 */
class Health extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::Heart;

    protected static ?string $navigationLabel = 'Health';

    protected static ?string $title = 'Bot health';

    protected static ?int $navigationSort = 30;

    protected string $view = 'mattermost::filament.pages.health';

    /**
     * @return array<string, mixed>
     */
    public function getApiHealth(): array
    {
        $start = microtime(true);

        try {
            $response = $this->mattermost()->system()->getPing();
            $latencyMs = (int) round((microtime(true) - $start) * 1000);

            return [
                'reachable' => $response->successful(),
                'latency_ms' => $latencyMs,
                'status' => $response->status(),
                'error' => null,
            ];
        } catch (Throwable $e) {
            return [
                'reachable' => false,
                'latency_ms' => null,
                'status' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    public function getWebSocketState(): ConnectionState
    {
        return $this->stats()->connectionState();
    }

    /**
     * @return array<string, mixed>
     */
    public function getBotIdentity(): array
    {
        try {
            $response = $this->mattermost()->users()->getUser('me');

            if (! $response->successful()) {
                return ['ok' => false, 'id' => null, 'username' => null, 'roles' => null];
            }

            /** @var array<string, mixed> $data */
            $data = $response->json();

            return [
                'ok' => true,
                'id' => is_string($data['id'] ?? null) ? $data['id'] : null,
                'username' => is_string($data['username'] ?? null) ? $data['username'] : null,
                'roles' => is_string($data['roles'] ?? null) ? $data['roles'] : null,
            ];
        } catch (Throwable) {
            return ['ok' => false, 'id' => null, 'username' => null, 'roles' => null];
        }
    }

    /**
     * @param  array<string, mixed>|null  $identity  Pre-resolved identity from getViewData() to avoid re-fetching /users/me.
     * @return array<int, array<string, mixed>>
     */
    public function getChannelMemberships(?array $identity = null): array
    {
        $identity ??= $this->getBotIdentity();
        $userId = $identity['id'] ?? null;

        if (! is_string($userId) || $userId === '') {
            return [];
        }

        try {
            $response = $this->mattermost()->channels()->getChannelsForUser($userId);

            if (! $response->successful()) {
                return [];
            }

            /** @var array<int, array<string, mixed>> $channels */
            $channels = $response->json();

            return array_values(array_map(
                fn (array $channel): array => [
                    'id' => is_string($channel['id'] ?? null) ? $channel['id'] : '',
                    'name' => is_string($channel['name'] ?? null) ? $channel['name'] : '',
                    'display_name' => is_string($channel['display_name'] ?? null) ? $channel['display_name'] : '',
                    'type' => is_string($channel['type'] ?? null) ? $channel['type'] : '',
                ],
                $channels,
            ));
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * @return array<string, mixed>
     */
    #[\Override]
    protected function getViewData(): array
    {
        $identity = $this->getBotIdentity();

        return [
            'api' => $this->getApiHealth(),
            'webSocketState' => $this->getWebSocketState(),
            'identity' => $identity,
            'channels' => $this->getChannelMemberships($identity),
        ];
    }

    private function mattermost(): Mattermost
    {
        return app(MattermostManager::class)->connection();
    }

    private function stats(): MattermostStats
    {
        return app(MattermostStats::class);
    }
}
