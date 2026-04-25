<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware;

use Closure;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Contracts\Cache\Repository as CacheRepository;

/**
 * Drop duplicate post-events using a cache lock.
 *
 * Mattermost can occasionally redeliver the same event after a reconnect or
 * across multiple bot replicas. We `add()` a key for `channel:post` (Laravel's
 * cache `add()` is the cross-store equivalent of Redis `setnx`). If the key
 * already existed, the post is a duplicate and the pipeline short-circuits.
 *
 * Configurable via `mattermost.bot.dedup_ttl` (seconds, default 60). Users
 * may bind any cache repo — Redis, file, array — by swapping
 * {@see CacheRepository} in the container.
 */
class Dedup implements Middleware
{
    public function __construct(
        private readonly CacheRepository $cache,
    ) {}

    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        $key = $this->resolveDedupKey($event);

        if ($key === null) {
            $next($event);

            return;
        }

        $ttl = $this->resolveTtl();

        if (! $this->cache->add($key, true, $ttl)) {
            // Already seen.
            return;
        }

        $next($event);
    }

    private function resolveDedupKey(Event $event): ?string
    {
        if (! $event instanceof PostCreated) {
            return null;
        }

        $post = $event->post();

        if ($post === null) {
            return null;
        }

        $postId = is_string($post['id'] ?? null) ? $post['id'] : null;
        $channelId = $event->channelId();

        if ($postId === null || $postId === '' || $channelId === '') {
            return null;
        }

        return sprintf('mattermost:bot:dedup:%s:%s', $channelId, $postId);
    }

    private function resolveTtl(): int
    {
        $configured = config('mattermost.bot.dedup_ttl', 60);

        return is_numeric($configured) ? max(1, (int) $configured) : 60;
    }
}
