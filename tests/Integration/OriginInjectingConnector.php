<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Integration;

use ConduitUI\Mattermost\WebSocket\Contracts\WebSocketConnector;
use Override;
use Ratchet\Client\Connector as PawlClientConnector;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

/**
 * WebSocket connector that injects an `Origin` header on every connect.
 *
 * Mattermost rejects the WS upgrade with 403 + a CORS error when the
 * `Origin` header doesn't match the configured SiteURL. The production
 * `PawlConnector` doesn't set Origin (production callers usually run from
 * the same origin as the server, where browsers / kube networking handles
 * it). For the integration suite we point Origin at the configured
 * `MATTERMOST_URL` so Pawl-driven test connections survive the CORS check.
 */
final readonly class OriginInjectingConnector implements WebSocketConnector
{
    private PawlClientConnector $connector;

    public function __construct(
        LoopInterface $loop,
        private string $origin,
    ) {
        $this->connector = new PawlClientConnector($loop);
    }

    #[Override]
    public function connect(string $url, array $subProtocols = [], array $headers = []): PromiseInterface
    {
        $headers = array_merge(['Origin' => $this->origin], $headers);
        $connector = $this->connector;

        return $connector($url, $subProtocols, $headers);
    }
}
