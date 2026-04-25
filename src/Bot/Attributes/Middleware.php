<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Attributes;

use Attribute;
use ConduitUI\Mattermost\Bot\Handler;

/**
 * Declare per-handler middleware on a {@see Handler}
 * subclass.
 *
 * The router resolves the listed middleware classes from the container and
 * runs them in order *after* the globally configured pipeline.
 *
 *   #[Middleware(IgnoreBots::class, RateLimit::class, Dedup::class)]
 *   class HandleMentions extends Handler { ... }
 */
#[Attribute(Attribute::TARGET_CLASS)]
final readonly class Middleware
{
    /** @var array<int, class-string> */
    public array $middleware;

    /**
     * @param  class-string  ...$middleware
     */
    public function __construct(string ...$middleware)
    {
        $this->middleware = array_values($middleware);
    }
}
