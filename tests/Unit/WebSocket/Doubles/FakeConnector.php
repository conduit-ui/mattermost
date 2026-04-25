<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles;

use Closure;
use ConduitUI\Mattermost\WebSocket\Contracts\WebSocketConnector;
use React\Promise\Deferred;
use React\Promise\PromiseInterface;
use Throwable;

/**
 * Test double for `WebSocketConnector` — drives connect/error sequences
 * deterministically.
 *
 * Each call to `connect()` returns a fresh promise. The factory closure
 * (passed in via `setBehaviour`) decides whether to resolve, reject, or
 * leave pending so the test can drive event timings.
 */
final class FakeConnector implements WebSocketConnector
{
    /** @var list<string> */
    public array $calls = [];

    /** @var Closure(int, Deferred): void */
    private Closure $behaviour;

    public function __construct()
    {
        // default: leave the promise pending
        $this->behaviour = static function (int $attempt, Deferred $deferred): void {};
    }

    /**
     * @param  Closure(int, Deferred): void  $behaviour
     */
    public function setBehaviour(Closure $behaviour): void
    {
        $this->behaviour = $behaviour;
    }

    /**
     * Convenience: always resolve with the given fake socket.
     */
    public function alwaysResolveWith(FakeWebSocket $socket): void
    {
        $this->behaviour = static function (int $attempt, Deferred $deferred) use ($socket): void {
            $deferred->resolve($socket);
        };
    }

    /**
     * Convenience: always reject with the given throwable.
     */
    public function alwaysRejectWith(Throwable $error): void
    {
        $this->behaviour = static function (int $attempt, Deferred $deferred) use ($error): void {
            $deferred->reject($error);
        };
    }

    #[\Override]
    public function connect(string $url, array $subProtocols = [], array $headers = []): PromiseInterface
    {
        $this->calls[] = $url;
        $deferred = new Deferred;
        ($this->behaviour)(count($this->calls), $deferred);

        return $deferred->promise();
    }
}
