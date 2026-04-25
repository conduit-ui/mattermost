<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles;

use ArrayIterator;
use IteratorAggregate;
use Ratchet\RFC6455\Messaging\FrameInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;

/**
 * Stand-in for `Ratchet\RFC6455\Messaging\Message` that exposes only the
 * surface our `Client::handleFrame` needs (`(string) $message`).
 *
 * @implements IteratorAggregate<int, FrameInterface>
 */
final class FakeMessage implements IteratorAggregate, MessageInterface
{
    public function __construct(private readonly string $payload) {}

    #[\Override]
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator([]);
    }

    #[\Override]
    public function count(): int
    {
        return 0;
    }

    #[\Override]
    public function isCoalesced(): bool
    {
        return true;
    }

    #[\Override]
    public function getPayloadLength(): int
    {
        return strlen($this->payload);
    }

    #[\Override]
    public function getPayload(): string
    {
        return $this->payload;
    }

    #[\Override]
    public function getContents(): string
    {
        return $this->payload;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->payload;
    }

    #[\Override]
    public function addFrame(FrameInterface $fragment): self
    {
        return $this;
    }

    #[\Override]
    public function getOpcode(): int
    {
        return 1; // text
    }

    #[\Override]
    public function isBinary(): bool
    {
        return false;
    }
}
