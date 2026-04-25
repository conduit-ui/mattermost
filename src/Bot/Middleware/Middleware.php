<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware;

use Closure;
use ConduitUI\Mattermost\WebSocket\Events\Event;

/**
 * Pipeline middleware for the bot Router.
 *
 * Each middleware decides whether the event should continue down the
 * pipeline. To pass control along, call `$next($event)`. To short-circuit
 * (e.g. drop a duplicate event, ignore a bot user, deny non-admins) simply
 * `return` without calling `$next`.
 */
interface Middleware
{
    /**
     * @param  Closure(Event): void  $next
     */
    public function handle(Event $event, Closure $next): void;
}
