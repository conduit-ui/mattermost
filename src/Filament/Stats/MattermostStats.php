<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Filament\Stats;

use ConduitUI\Mattermost\WebSocket\ConnectionState;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

/**
 * Cache-backed runtime stats for the Mattermost bot.
 *
 * Acts as a lightweight write/read seam between the bot framework / WS client
 * (which push live data) and Filament pages (which read it). Uses the cache
 * store so it works across long-running listener processes and short-lived
 * web requests in the same way.
 *
 * The bot framework (issue #4) is expected to call:
 *   - markConnected() / markDisconnected() / markReconnecting() on WS state changes
 *   - incrementMessagesProcessed() each time a handler dispatches
 *   - markStarted() once on listener boot (sets the uptime anchor)
 *
 * Pages always work even when no stats have been written (returns sensible defaults).
 */
class MattermostStats
{
    private const string CACHE_PREFIX = 'mattermost.stats.';

    private const int TTL_SECONDS = 86400;

    public function __construct(
        private readonly CacheRepository $cache,
        private readonly string $connection = 'default',
    ) {}

    public function connectionState(): ConnectionState
    {
        $value = $this->cache->get($this->key('state'));

        if (is_string($value)) {
            return ConnectionState::tryFrom($value) ?? ConnectionState::Disconnected;
        }

        return ConnectionState::Disconnected;
    }

    public function setConnectionState(ConnectionState $state): void
    {
        $this->cache->put($this->key('state'), $state->value, self::TTL_SECONDS);
    }

    public function markConnected(): void
    {
        $this->setConnectionState(ConnectionState::Connected);
    }

    public function markDisconnected(): void
    {
        $this->setConnectionState(ConnectionState::Disconnected);
    }

    public function markReconnecting(): void
    {
        $this->setConnectionState(ConnectionState::Reconnecting);
    }

    public function startedAt(): ?int
    {
        $value = $this->cache->get($this->key('started_at'));

        return is_int($value) ? $value : null;
    }

    public function markStarted(?int $timestamp = null): void
    {
        $this->cache->put(
            $this->key('started_at'),
            $timestamp ?? time(),
            self::TTL_SECONDS,
        );
    }

    public function uptimeSeconds(): ?int
    {
        $startedAt = $this->startedAt();

        if ($startedAt === null) {
            return null;
        }

        return max(0, time() - $startedAt);
    }

    public function messagesProcessed(): int
    {
        $value = $this->cache->get($this->key('messages_processed'), 0);

        return is_int($value) ? $value : 0;
    }

    public function incrementMessagesProcessed(int $by = 1): int
    {
        $current = $this->messagesProcessed();
        $next = $current + $by;
        $this->cache->put($this->key('messages_processed'), $next, self::TTL_SECONDS);

        return $next;
    }

    public function reset(): void
    {
        foreach (['state', 'started_at', 'messages_processed'] as $suffix) {
            $this->cache->forget($this->key($suffix));
        }
    }

    public function connection(): string
    {
        return $this->connection;
    }

    private function key(string $suffix): string
    {
        return self::CACHE_PREFIX.$this->connection.'.'.$suffix;
    }
}
