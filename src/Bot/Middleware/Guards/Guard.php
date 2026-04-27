<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot\Middleware\Guards;

use ConduitUI\Mattermost\Bot\Middleware\Middleware;

/**
 * Contract for permission-based middleware guards.
 *
 * Guards extend the standard middleware contract with a semantic `authorize`
 * method. Implementations should return `true` to allow the event through,
 * or `false` to short-circuit the pipeline.
 */
interface Guard extends Middleware
{
    /**
     * Determine whether the given user is authorized for the given context.
     */
    public function authorize(string $userId, string $channelId): bool;
}
