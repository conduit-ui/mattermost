<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware;

use Closure;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;

/**
 * Skip events authored by bot users (including this bot itself).
 *
 * Without this, a bot that replies to mentions can self-trigger when its own
 * post arrives back over the WebSocket. Recognises two signals:
 *
 *  1. The post's `props.from_bot` flag is `true` (set by Mattermost on any
 *     bot-authored post).
 *  2. The post's author matches the `bot_user_id` of any configured
 *     connection — not just the active one. This is intentional for a
 *     global middleware: a multi-server deployment may share state, and
 *     dropping events authored by a peer bot is almost always the right call.
 */
class IgnoreBots implements Middleware
{
    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        if (! $event instanceof PostCreated) {
            $next($event);

            return;
        }

        if ($this->isFromBot($event)) {
            return;
        }

        $next($event);
    }

    private function isFromBot(PostCreated $event): bool
    {
        $post = $event->post();

        if ($post === null) {
            return false;
        }

        $fromBot = $post['props']['from_bot'] ?? null;

        if ($fromBot === true || $fromBot === 'true') {
            return true;
        }

        $authorId = $event->userId();

        if ($authorId === '') {
            return false;
        }

        return array_any($this->configuredBotUserIds(), fn ($botId): bool => $botId !== '' && $botId === $authorId);
    }

    /**
     * @return array<int, string>
     */
    private function configuredBotUserIds(): array
    {
        $connections = config('mattermost.connections', []);
        $ids = [];

        if (! is_array($connections)) {
            return [];
        }

        foreach ($connections as $config) {
            if (! is_array($config)) {
                continue;
            }

            $id = $config['bot_user_id'] ?? null;

            if (is_string($id) && $id !== '') {
                $ids[] = $id;
            }
        }

        return $ids;
    }
}
