<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles;

use Evenement\EventEmitterTrait;
use Ratchet\Client\WebSocket;

/**
 * Fake `Ratchet\Client\WebSocket` for unit tests.
 *
 * Inherits the real type so it satisfies the `Client::$socket` declared
 * type, but skips the parent constructor (which needs a live socket
 * stream + PSR-7 messages we don't want to fabricate).
 *
 * Provides:
 *  - `send($payload)` → captures the frame in `$sent` for assertions.
 *  - `close($code, $reason)` → emits the `close` event so the Client's
 *    onClose path runs. Records `$closeCalls` for assertions.
 */
final class FakeWebSocket extends WebSocket
{
    use EventEmitterTrait;

    /** @var list<string> */
    public array $sent = [];

    /** @var list<array{code: int, reason: string}> */
    public array $closeCalls = [];

    public function __construct()
    {
        // Intentionally do NOT call parent::__construct — we don't have
        // a real React stream and don't need one for these tests.
    }

    #[\Override]
    public function send($msg)
    {
        $this->sent[] = (string) $msg;

        return $this;
    }

    #[\Override]
    public function close($code = 1000, $reason = '')
    {
        $this->closeCalls[] = ['code' => (int) $code, 'reason' => (string) $reason];
        $this->emit('close', [$code, $reason]);
    }

    public function emitMessage(string $payload): void
    {
        $message = new FakeMessage($payload);
        $this->emit('message', [$message]);
    }
}
