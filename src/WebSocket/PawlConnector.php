<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket;

use ConduitUI\Mattermost\WebSocket\Contracts\WebSocketConnector;
use Ratchet\Client\Connector as PawlClientConnector;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

/**
 * Default `WebSocketConnector` implementation backed by `ratchet/pawl`.
 *
 * Thin wrapper — exists so we can mock the connector seam in unit tests
 * and keep the `Client` framework-agnostic.
 */
final readonly class PawlConnector implements WebSocketConnector
{
    private PawlClientConnector $connector;

    public function __construct(LoopInterface $loop)
    {
        $this->connector = new PawlClientConnector($loop);
    }

    #[\Override]
    public function connect(string $url, array $subProtocols = [], array $headers = []): PromiseInterface
    {
        $connector = $this->connector;

        return $connector($url, $subProtocols, $headers);
    }
}
