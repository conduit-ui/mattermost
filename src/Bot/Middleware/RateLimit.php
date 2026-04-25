<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware;

use Closure;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

/**
 * Per-channel cooldown for handler invocations.
 *
 * Drops events that arrive within `mattermost.bot.rate_limit_seconds` (default
 * 30) of the last accepted event for the same channel. DMs are always allowed
 * through — direct conversation should never be rate-limited.
 */
class RateLimit implements Middleware
{
    public function __construct(
        private readonly CacheRepository $cache,
    ) {}

    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        if (! $event instanceof PostCreated) {
            $next($event);

            return;
        }

        if ($this->isDirectMessage($event)) {
            $next($event);

            return;
        }

        $channelId = $event->channelId();

        if ($channelId === '') {
            $next($event);

            return;
        }

        $key = sprintf('mattermost:bot:ratelimit:%s', $channelId);
        $cooldown = $this->resolveCooldown();

        if (! $this->cache->add($key, true, $cooldown)) {
            return;
        }

        $next($event);
    }

    private function isDirectMessage(PostCreated $event): bool
    {
        return $event->channelType() === 'D';
    }

    private function resolveCooldown(): int
    {
        $configured = config('mattermost.bot.rate_limit_seconds', 30);

        return is_numeric($configured) ? max(1, (int) $configured) : 30;
    }
}
