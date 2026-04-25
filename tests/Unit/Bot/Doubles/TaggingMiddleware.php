<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\Bot\Doubles;

use Closure;
use ConduitUI\Mattermost\Bot\Middleware\Middleware;
use ConduitUI\Mattermost\WebSocket\Events\Event;

class TaggingMiddleware implements Middleware
{
    /** @var array<int, string> */
    public static array $tags = [];

    public static function reset(): void
    {
        self::$tags = [];
    }

    #[\Override]
    public function handle(Event $event, Closure $next): void
    {
        self::$tags[] = 'before';
        $next($event);
        self::$tags[] = 'after';
    }
}
