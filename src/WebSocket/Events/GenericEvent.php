<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Fallback event for any Mattermost event we don't model with a typed
 * subclass yet. Preserves the original event name plus the raw payload
 * so callers can still inspect unrecognised frames.
 */
final class GenericEvent extends Event
{
    public function __construct(
        private readonly string $name,
        array $data,
        array $broadcast,
        int $seq,
    ) {
        parent::__construct($data, $broadcast, $seq);
    }

    #[\Override]
    public function name(): string
    {
        return $this->name;
    }
}
