<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\Bot\Doubles;

use Closure;
use ConduitUI\Mattermost\Bot\Middleware\Middleware;
use ConduitUI\Mattermost\WebSocket\Events\Event;

class ShortCircuitMiddleware implements Middleware
{
    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        // Drop everything.
    }
}
