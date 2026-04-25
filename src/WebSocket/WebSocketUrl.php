<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket;

use InvalidArgumentException;

/**
 * Helper to build the Mattermost WebSocket endpoint URL from the REST
 * connector base URL.
 *
 * The mapping is `http://` → `ws://`, `https://` → `wss://`, then we
 * append `/api/v4/websocket` (Mattermost's fixed WS path).
 */
final class WebSocketUrl
{
    private const string PATH = '/api/v4/websocket';

    public static function fromBaseUrl(string $baseUrl): string
    {
        $trimmed = rtrim($baseUrl, '/');

        if ($trimmed === '') {
            throw new InvalidArgumentException('Mattermost base URL cannot be empty.');
        }

        if (str_starts_with($trimmed, 'https://')) {
            return 'wss://'.substr($trimmed, 8).self::PATH;
        }

        if (str_starts_with($trimmed, 'http://')) {
            return 'ws://'.substr($trimmed, 7).self::PATH;
        }

        if (str_starts_with($trimmed, 'wss://') || str_starts_with($trimmed, 'ws://')) {
            return $trimmed.self::PATH;
        }

        throw new InvalidArgumentException(
            "Mattermost base URL must use http(s):// or ws(s):// scheme; got: {$baseUrl}"
        );
    }
}
