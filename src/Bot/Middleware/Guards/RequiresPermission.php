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
 * Guard that requires the post author to have a specific Mattermost permission.
 *
 * Mattermost encodes permissions into role strings on the user object. This
 * guard checks for well-known role→permission mappings. For example, the
 * `manage_team` permission maps to `team_admin` or `system_admin` roles.
 *
 * The result is cached per-user for `mattermost.bot.guard_cache_ttl` seconds
 * (default 300).
 */
class RequiresPermission implements Guard
{
    /**
     * Map of permission names to the roles that grant them.
     *
     * @var array<string, array<int, string>>
     */
    private const array PERMISSION_ROLE_MAP = [
        'manage_team' => ['team_admin', 'system_admin'],
        'manage_channel' => ['channel_admin', 'team_admin', 'system_admin'],
        'manage_system' => ['system_admin'],
        'create_post' => ['system_user', 'team_admin', 'system_admin'],
        'manage_webhooks' => ['team_admin', 'system_admin'],
        'manage_slash_commands' => ['team_admin', 'system_admin'],
        'manage_others_webhooks' => ['system_admin'],
        'manage_oauth' => ['system_admin'],
        'manage_roles' => ['system_admin'],
    ];

    public function __construct(
        private readonly MattermostManager $mattermost,
        private readonly CacheRepository $cache,
        private readonly string $permission = 'manage_team',
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
        return $this->hasPermission($userId);
    }

    private function hasPermission(string $userId): bool
    {
        $key = sprintf('mattermost:bot:guard:permission:%s:%s', $this->permission, $userId);
        $ttl = $this->resolveTtl();

        $cached = $this->cache->get($key);

        if (is_bool($cached)) {
            return $cached;
        }

        $result = $this->fetchHasPermission($userId);

        $this->cache->put($key, $result, $ttl);

        return $result;
    }

    private function fetchHasPermission(string $userId): bool
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
        $requiredRoles = self::PERMISSION_ROLE_MAP[$this->permission] ?? [];

        if ($requiredRoles === []) {
            return false;
        }

        return array_any($requiredRoles, fn (string $role): bool => in_array($role, $userRoles, true));
    }

    private function resolveTtl(): int
    {
        $configured = config('mattermost.bot.guard_cache_ttl', 300);

        return is_numeric($configured) ? max(1, (int) $configured) : 300;
    }
}
