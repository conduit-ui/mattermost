<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware;

use Closure;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;

/**
 * Allowlist channels. Events from any channel not in
 * `mattermost.bot.allowed_channels` (by id or by name) are dropped.
 *
 * When the allowlist is empty or unset, every event passes through — this
 * middleware is opt-in.
 */
class ChannelFilter implements Middleware
{
    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        $allowed = $this->configuredAllowList();

        if ($allowed === []) {
            $next($event);

            return;
        }

        if (! $event instanceof PostCreated) {
            $next($event);

            return;
        }

        $channelId = $event->channelId();
        $channelName = $event->channelName();

        if ($this->matches($allowed, $channelId, $channelName)) {
            $next($event);
        }
    }

    /**
     * @param  array<int, string>  $allowed
     */
    private function matches(array $allowed, string $channelId, string $channelName): bool
    {
        foreach ($allowed as $value) {
            if ($value === '') {
                continue;
            }

            if ($value === $channelId || $value === $channelName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return array<int, string>
     */
    private function configuredAllowList(): array
    {
        $configured = config('mattermost.bot.allowed_channels', []);

        if (! is_array($configured)) {
            return [];
        }

        $allowed = [];

        foreach ($configured as $value) {
            if (is_string($value) && $value !== '') {
                $allowed[] = $value;
            }
        }

        return $allowed;
    }
}
