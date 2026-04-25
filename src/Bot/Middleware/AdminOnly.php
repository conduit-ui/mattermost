<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware;

use Closure;
use ConduitUI\Mattermost\Client\Requests\Users\GetUser;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Throwable;

/**
 * Restrict a handler to admins.
 *
 * Looks up the post author via `GET /users/{id}` and checks the returned
 * `roles` string for `system_admin`, `team_admin`, or `channel_admin`. Posts
 * from non-admins are dropped.
 *
 * The admin status is cached for `mattermost.bot.admin_cache_ttl` seconds
 * (default 300) so we don't hammer the API for every event.
 */
class AdminOnly implements Middleware
{
    /** @var array<int, string> */
    private const array ADMIN_ROLES = ['system_admin', 'team_admin', 'channel_admin'];

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

        if ($userId === '') {
            return;
        }

        if (! $this->isAdmin($userId)) {
            return;
        }

        $next($event);
    }

    private function isAdmin(string $userId): bool
    {
        $key = sprintf('mattermost:bot:admin:%s', $userId);
        $ttl = $this->resolveTtl();

        $cached = $this->cache->get($key);

        if (is_bool($cached)) {
            return $cached;
        }

        $isAdmin = $this->fetchAdminStatus($userId);

        $this->cache->put($key, $isAdmin, $ttl);

        return $isAdmin;
    }

    private function fetchAdminStatus(string $userId): bool
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

        return array_any(self::ADMIN_ROLES, fn ($adminRole): bool => in_array($adminRole, $userRoles, true));
    }

    private function resolveTtl(): int
    {
        $configured = config('mattermost.bot.admin_cache_ttl', 300);

        return is_numeric($configured) ? max(1, (int) $configured) : 300;
    }
}
