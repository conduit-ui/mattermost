<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Contracts;

use Ratchet\Client\WebSocket;
use React\Promise\PromiseInterface;

/**
 * Tiny abstraction over `Ratchet\Client\Connector` so the WebSocket client
 * can be exercised in unit tests without opening real TCP sockets.
 *
 * Implementations resolve to a Pawl `WebSocket` instance (or a mock
 * implementing the same `Evenement\EventEmitterInterface` + `send/close`
 * contract) on success, and reject with `\Throwable` on failure.
 */
interface WebSocketConnector
{
    /**
     * @param  string  $url  ws:// or wss:// URL
     * @param  array<int, string>  $subProtocols
     * @param  array<string, string>  $headers
     * @return PromiseInterface<WebSocket>
     */
    public function connect(string $url, array $subProtocols = [], array $headers = []): PromiseInterface;
}
