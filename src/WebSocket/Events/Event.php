<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Base class for typed Mattermost WebSocket events.
 *
 * Mattermost wraps every event frame as:
 * `{ event: string, data: array, broadcast: array, seq: int }`
 *
 * Subclasses expose convenience getters over the `data` payload while
 * preserving the raw arrays for callers that want everything.
 */
abstract class Event
{
    /**
     * @param  array<string, mixed>  $data  Event-specific payload.
     * @param  array<string, mixed>  $broadcast  Routing info (channel_id, team_id, user_id, omit_users).
     * @param  int  $seq  Server sequence number.
     */
    public function __construct(
        public readonly array $data,
        public readonly array $broadcast,
        public readonly int $seq,
    ) {}

    /**
     * The Mattermost event name, e.g. `posted`, `post_edited`.
     */
    abstract public function name(): string;
}
