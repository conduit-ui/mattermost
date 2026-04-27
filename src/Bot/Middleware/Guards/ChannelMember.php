<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware\Guards;

use Closure;
use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelMember;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Throwable;

/**
 * Guard that only allows events from users who are members of the post's channel.
 *
 * Uses `GET /channels/{id}/members/{userId}` to verify membership. A 200
 * response means the user is a member; any error (404, 403, etc.) means they
 * are not. Results are cached per user+channel pair for
 * `mattermost.bot.guard_cache_ttl` seconds (default 300).
 */
class ChannelMember implements Guard
{
    public function __construct(
        private readonly MattermostManager $mattermost,
        private readonly CacheRepository $cache,
    ) {}

    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        if (! $event instanceof PostCreated) {
            $next($event);

            return;
        }

        $userId = $event->userId();
        $channelId = $event->channelId();

        if ($userId === '' || $channelId === '') {
            return;
        }

        if (! $this->authorize($userId, $channelId)) {
            return;
        }

        $next($event);
    }

    #[\Override]
    public function authorize(string $userId, string $channelId): bool
    {
        return $this->isMember($userId, $channelId);
    }

    private function isMember(string $userId, string $channelId): bool
    {
        $key = sprintf('mattermost:bot:guard:channel_member:%s:%s', $channelId, $userId);
        $ttl = $this->resolveTtl();

        $cached = $this->cache->get($key);

        if (is_bool($cached)) {
            return $cached;
        }

        $result = $this->fetchMembership($userId, $channelId);

        $this->cache->put($key, $result, $ttl);

        return $result;
    }

    private function fetchMembership(string $userId, string $channelId): bool
    {
        try {
            $response = $this->mattermost->connection()->send(
                new GetChannelMember($channelId, $userId),
            );

            return $response->successful();
        } catch (Throwable) {
            return false;
        }
    }

    private function resolveTtl(): int
    {
        $configured = config('mattermost.bot.guard_cache_ttl', 300);

        return is_numeric($configured) ? max(1, (int) $configured) : 300;
    }
}
