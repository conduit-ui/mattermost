<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware\Guards;

use Closure;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Throwable;

/**
 * Guard that requires the post author to have a specific Mattermost role.
 *
 * Checks the `roles` field from `GET /users/{id}` for the configured role
 * string (e.g. `system_admin`, `team_admin`). The result is cached per-user
 * for `mattermost.bot.guard_cache_ttl` seconds (default 300).
 */
class RequiresRole implements Guard
{
    public function __construct(
        private readonly MattermostManager $mattermost,
        private readonly CacheRepository $cache,
        private readonly string $role = 'system_admin',
    ) {}

    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        if (! $event instanceof PostCreated) {
            $next($event);

            return;
        }

        $userId = $event->userId();

        if ($userId === '') {
            return;
        }

        if (! $this->authorize($userId, $event->channelId())) {
            return;
        }

        $next($event);
    }

    #[\Override]
    public function authorize(string $userId, string $channelId): bool
    {
        return $this->hasRole($userId);
    }

    private function hasRole(string $userId): bool
    {
        $key = sprintf('mattermost:bot:guard:role:%s:%s', $this->role, $userId);
        $ttl = $this->resolveTtl();

        $cached = $this->cache->get($key);

        if (is_bool($cached)) {
            return $cached;
        }

        $result = $this->fetchHasRole($userId);

        $this->cache->put($key, $result, $ttl);

        return $result;
    }

    private function fetchHasRole(string $userId): bool
    {
        try {
            $response = $this->mattermost->connection()->send(new GetUser($userId));
            $payload = $response->json();
        } catch (Throwable) {
            return false;
        }

        $roles = $payload['roles'] ?? '';

        if (! is_string($roles) || $roles === '') {
            return false;
        }

        $userRoles = preg_split('/\s+/', trim($roles)) ?: [];

        return in_array($this->role, $userRoles, true);
    }

    private function resolveTtl(): int
    {
        $configured = config('mattermost.bot.guard_cache_ttl', 300);

        return is_numeric($configured) ? max(1, (int) $configured) : 300;
    }
}
