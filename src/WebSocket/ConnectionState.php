<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket;

/**
 * Lifecycle states for the WebSocket client. Used for state-change logging
 * and as a source of truth callers can query (e.g. health checks).
 */
enum ConnectionState: string
{
    case Disconnected = 'disconnected';
    case Connecting = 'connecting';
    case Authenticating = 'authenticating';
    case Connected = 'connected';
    case Reconnecting = 'reconnecting';
    case Closing = 'closing';
}
