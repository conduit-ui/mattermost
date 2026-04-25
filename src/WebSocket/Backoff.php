<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket;

/**
 * Exponential reconnect backoff: 1s, 2s, 4s, 8s ... up to a configurable
 * maximum. `reset()` is called after a successful authentication so future
 * disconnects start from 1s again.
 */
final class Backoff
{
    private int $current;

    public function __construct(
        private readonly int $initial = 1,
        private readonly int $max = 60,
    ) {
        $this->current = max(1, $initial);
    }

    /**
     * Returns the next delay (in seconds) and advances the schedule.
     */
    public function next(): int
    {
        $delay = min($this->current, $this->max);
        $this->current = min($this->current * 2, $this->max);

        return $delay;
    }

    public function reset(): void
    {
        $this->current = max(1, $this->initial);
    }

    public function current(): int
    {
        return min($this->current, $this->max);
    }
}
