<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\Bot\Doubles;

use ConduitUI\Mattermost\Bot\Attributes\Middleware;
use ConduitUI\Mattermost\Bot\Handler;
use ConduitUI\Mattermost\WebSocket\Events\Event;

#[Middleware(TaggingMiddleware::class)]
class HandlerWithMiddleware extends Handler
{
    /** @var array<int, Event> */
    public static array $invocations = [];

    public static function reset(): void
    {
        self::$invocations = [];
    }

    #[\Override]
    public function handle(Event $event): void
    {
        self::$invocations[] = $event;
    }
}
