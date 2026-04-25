<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket;

use ConduitUI\Mattermost\WebSocket\Contracts\WebSocketConnector;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\EventFactory;
use ConduitUI\Mattermost\WebSocket\Events\Hello;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\MessageInterface;
use React\EventLoop\Loop;
use React\EventLoop\LoopInterface;
use React\EventLoop\TimerInterface;
use Throwable;

/**
 * Mattermost WebSocket client.
 *
 * Long-lived event-loop driven client for `/api/v4/websocket`. Owns the
 * full reconnect lifecycle:
 *
 *  1. Connect via the injected `WebSocketConnector` (Pawl by default).
 *  2. Send `authentication_challenge` with the bot token (seq 1).
 *  3. On every server frame, dispatch:
 *       - `status: OK` reply → mark authenticated, reset backoff.
 *       - `event: hello` → also dispatched as a `Hello` event.
 *       - typed event → invoke listeners for that event name + wildcard.
 *  4. On close, schedule a reconnect with exponential backoff (1, 2, 4
 *     ... up to `reconnect_max_delay`). Initiation is idempotent so a
 *     concurrent close + heartbeat-recycle don't double-schedule.
 *  5. On SIGTERM/SIGINT, set `selfInitiatedClose`, close the socket,
 *     stop the loop. The shell-level reconnect loop pattern from the
 *     reference implementation is intentionally not used here — a single
 *     long-lived loop avoids fd leaks across reconnects.
 *
 * The client is intentionally framework-agnostic. Laravel callers wire
 * the logger via `Log::channel('mattermost')` from a console command;
 * unit tests inject a no-op connector and a `BufferingLogger` to assert
 * lifecycle behaviour without opening sockets.
 *
 * Listener registration is type-fluent:
 *
 *   $client->on(PostCreated::class, function (PostCreated $e) { ... });
 *   $client->onAny(function (Event $e) { ... });
 *
 * Listeners are called in registration order. Throwing a listener does
 * not crash the loop — exceptions are logged and swallowed.
 */
final class Client
{
    private readonly LoggerInterface $logger;

    private readonly LoopInterface $loop;

    private readonly WebSocketConnector $connector;

    private readonly Backoff $backoff;

    private readonly int $pingIntervalSeconds;

    private readonly int $heartbeatTimeoutSeconds;

    private readonly int $serverEvictionDelaySeconds;

    private readonly string $wsUrl;

    /** @var array<string, array<int, callable(Event): void>> */
    private array $listeners = [];

    /** @var array<int, callable(Event): void> */
    private array $wildcardListeners = [];

    private ?WebSocket $socket = null;

    private ?TimerInterface $heartbeatTimer = null;

    private ConnectionState $state = ConnectionState::Disconnected;

    private bool $reconnecting = false;

    private bool $selfInitiatedClose = false;

    private bool $running = false;

    private int $sequence = 2;

    private int $lastFrameAt = 0;

    public function __construct(
        string $baseUrl,
        private readonly string $token,
        ?LoggerInterface $logger = null,
        ?LoopInterface $loop = null,
        ?WebSocketConnector $connector = null,
        ?Backoff $backoff = null,
        int $pingIntervalSeconds = 30,
        int $heartbeatTimeoutSeconds = 120,
        int $serverEvictionDelaySeconds = 30,
    ) {
        $this->logger = $logger ?? new NullLogger;
        $this->loop = $loop ?? Loop::get();
        $this->connector = $connector ?? new PawlConnector($this->loop);
        $this->backoff = $backoff ?? new Backoff;
        $this->pingIntervalSeconds = max(1, $pingIntervalSeconds);
        $this->heartbeatTimeoutSeconds = max(1, $heartbeatTimeoutSeconds);
        $this->serverEvictionDelaySeconds = max(1, $serverEvictionDelaySeconds);
        $this->wsUrl = WebSocketUrl::fromBaseUrl($baseUrl);
    }

    /**
     * Register a listener for a specific typed event class (or Mattermost
     * event-name string for `GenericEvent` matches).
     *
     * @param  class-string<Event>|string  $eventClassOrName
     * @param  callable(Event): void  $handler
     */
    public function on(string $eventClassOrName, callable $handler): self
    {
        $this->listeners[$eventClassOrName][] = $handler;

        return $this;
    }

    /**
     * Register a listener invoked for every event (typed or generic).
     *
     * @param  callable(Event): void  $handler
     */
    public function onAny(callable $handler): self
    {
        $this->wildcardListeners[] = $handler;

        return $this;
    }

    public function state(): ConnectionState
    {
        return $this->state;
    }

    public function url(): string
    {
        return $this->wsUrl;
    }

    /**
     * Open the connection and run the event loop until disconnected.
     *
     * Installs SIGTERM/SIGINT handlers (where supported) so a graceful
     * shutdown closes the socket and exits the loop cleanly.
     */
    public function run(): void
    {
        if ($this->running) {
            return;
        }

        $this->running = true;
        $this->installSignalHandlers();
        $this->scheduleConnect(0);
        $this->loop->run();
    }

    /**
     * Initiate a graceful shutdown — close the socket, cancel timers,
     * stop the loop. Safe to call from a signal handler.
     */
    public function disconnect(): void
    {
        $this->setState(ConnectionState::Closing);
        $this->running = false;
        $this->selfInitiatedClose = true;

        $this->cancelHeartbeat();

        if ($this->socket instanceof WebSocket) {
            try {
                $this->socket->close();
            } catch (Throwable $e) {
                $this->logger->warning('Error closing Mattermost WS socket', ['error' => $e->getMessage()]);
            }
            $this->socket = null;
        }

        $this->loop->stop();
        $this->setState(ConnectionState::Disconnected);
    }

    /**
     * Idempotent: schedule a connect attempt after `$delaySeconds`.
     * A second call while a reconnect is already pending is a no-op.
     */
    private function scheduleConnect(int $delaySeconds): void
    {
        if ($this->reconnecting) {
            return;
        }

        if (! $this->running) {
            return;
        }

        $this->reconnecting = true;

        if ($delaySeconds > 0) {
            $this->setState(ConnectionState::Reconnecting);
            $this->logger->info('Mattermost WS reconnecting', [
                'url' => $this->wsUrl,
                'delay_seconds' => $delaySeconds,
            ]);
        } else {
            $this->setState(ConnectionState::Connecting);
        }

        $this->loop->addTimer(max(0, $delaySeconds), function (): void {
            $this->openSocket();
        });
    }

    private function openSocket(): void
    {
        $this->setState(ConnectionState::Connecting);
        $this->logger->info('Mattermost WS connecting', ['url' => $this->wsUrl]);

        $this->connector->connect($this->wsUrl)->then(
            function (WebSocket $conn): void {
                $this->onOpen($conn);
            },
            function (Throwable $error): void {
                $this->onConnectError($error);
            }
        );
    }

    private function onOpen(WebSocket $conn): void
    {
        $this->socket = $conn;
        $this->reconnecting = false;
        $this->sequence = 2;
        $this->lastFrameAt = time();
        $this->setState(ConnectionState::Authenticating);
        $this->logger->info('Mattermost WS connected, sending auth challenge');

        $this->sendAuthChallenge($conn);

        $conn->on('message', function (MessageInterface $message): void {
            $this->lastFrameAt = time();
            $this->handleFrame((string) $message);
        });

        $conn->on('close', function ($code = null, $reason = null): void {
            $this->onClose((int) ($code ?? 0), (string) ($reason ?? ''));
        });

        $conn->on('error', function (Throwable $error): void {
            $this->logger->warning('Mattermost WS error', ['error' => $error->getMessage()]);
        });

        $this->scheduleHeartbeat($conn);
    }

    private function sendAuthChallenge(WebSocket $conn): void
    {
        $payload = json_encode([
            'seq' => 1,
            'action' => 'authentication_challenge',
            'data' => ['token' => $this->token],
        ]);

        if ($payload === false) {
            $this->logger->error('Failed to encode Mattermost WS auth challenge');

            return;
        }

        $conn->send($payload);
    }

    private function scheduleHeartbeat(WebSocket $conn): void
    {
        $this->cancelHeartbeat();

        $this->heartbeatTimer = $this->loop->addPeriodicTimer(
            $this->pingIntervalSeconds,
            function () use ($conn): void {
                $this->emitHeartbeat($conn);
            }
        );
    }

    private function emitHeartbeat(WebSocket $conn): void
    {
        try {
            $payload = json_encode(['seq' => $this->sequence++, 'action' => 'ping']);

            if ($payload !== false) {
                $conn->send($payload);
            }
        } catch (Throwable $error) {
            $this->logger->warning('Mattermost WS heartbeat failed — recycling', [
                'error' => $error->getMessage(),
            ]);
            $this->selfInitiatedClose = true;
            $conn->close();

            return;
        }

        if ((time() - $this->lastFrameAt) > $this->heartbeatTimeoutSeconds) {
            $this->logger->warning('Mattermost WS heartbeat timeout — recycling', [
                'last_frame_seconds_ago' => time() - $this->lastFrameAt,
            ]);
            $this->selfInitiatedClose = true;
            $conn->close();
        }
    }

    private function cancelHeartbeat(): void
    {
        if ($this->heartbeatTimer instanceof TimerInterface) {
            $this->loop->cancelTimer($this->heartbeatTimer);
            $this->heartbeatTimer = null;
        }
    }

    private function onConnectError(Throwable $error): void
    {
        $this->reconnecting = false;
        $delay = $this->backoff->next();

        $this->logger->warning('Mattermost WS connect failed', [
            'error' => $error->getMessage(),
            'retry_in_seconds' => $delay,
        ]);

        $this->scheduleConnect($delay);
    }

    private function onClose(int $code, string $reason): void
    {
        $self = $this->selfInitiatedClose;
        $this->socket = null;
        $this->cancelHeartbeat();

        $this->logger->info('Mattermost WS closed', [
            'code' => $code,
            'reason' => $reason,
            'self_initiated' => $self,
        ]);

        // If the user called disconnect(), don't reconnect.
        if (! $this->running) {
            $this->setState(ConnectionState::Disconnected);

            return;
        }

        $delay = $this->resolveCloseDelay($code, $self);
        $this->selfInitiatedClose = false;
        $this->scheduleConnect($delay);
    }

    /**
     * Pick a reconnect delay based on the close code.
     *
     * Server-initiated close 1000 (normal closure) often indicates the
     * Mattermost server has evicted a duplicate session for the same bot
     * token. Backing off the standard 1s would cause an infinite flap, so
     * we hold for the full max delay before retrying.
     */
    private function resolveCloseDelay(int $code, bool $selfInitiated): int
    {
        if ($code === 1000 && ! $selfInitiated) {
            // Server kicked us — likely duplicate-session eviction.
            // Hold for a wider delay before retrying to avoid a flap.
            $this->backoff->reset();
            $this->logger->warning('Mattermost WS server-initiated close 1000 — extended backoff', [
                'delay_seconds' => $this->serverEvictionDelaySeconds,
            ]);

            return $this->serverEvictionDelaySeconds;
        }

        if ($selfInitiated) {
            // Self-recycle: nothing's wrong, retry quickly without
            // burning the backoff budget.
            return 1;
        }

        return $this->backoff->next();
    }

    private function handleFrame(string $raw): void
    {
        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            return;
        }

        // Auth-challenge ack → status: OK.
        if (($decoded['status'] ?? null) === 'OK' && $this->state === ConnectionState::Authenticating) {
            $this->setState(ConnectionState::Connected);
            $this->backoff->reset();
            $this->logger->info('Mattermost WS authenticated');

            return;
        }

        $event = EventFactory::fromArray($decoded);

        if (! $event instanceof Event) {
            return;
        }

        // The server's `hello` event arrives after a successful auth
        // and is a useful redundant "we're healthy" cue. If we somehow
        // missed the OK reply, accept hello as the same signal.
        if ($event instanceof Hello && $this->state === ConnectionState::Authenticating) {
            $this->setState(ConnectionState::Connected);
            $this->backoff->reset();
        }

        $this->dispatchEvent($event);
    }

    private function dispatchEvent(Event $event): void
    {
        $candidates = [];

        // Match against both the concrete class and the underlying
        // event-name string so users can subscribe either way.
        $candidates[] = $event::class;
        $candidates[] = $event->name();

        foreach ($candidates as $key) {
            foreach ($this->listeners[$key] ?? [] as $listener) {
                $this->invokeListener($listener, $event);
            }
        }

        foreach ($this->wildcardListeners as $listener) {
            $this->invokeListener($listener, $event);
        }
    }

    /**
     * @param  callable(Event): void  $listener
     */
    private function invokeListener(callable $listener, Event $event): void
    {
        try {
            $listener($event);
        } catch (Throwable $error) {
            $this->logger->error('Mattermost WS listener threw', [
                'event' => $event->name(),
                'error' => $error->getMessage(),
            ]);
        }
    }

    private function setState(ConnectionState $next): void
    {
        if ($this->state === $next) {
            return;
        }

        $this->logger->info('Mattermost WS state change', [
            'from' => $this->state->value,
            'to' => $next->value,
        ]);

        $this->state = $next;
    }

    private function installSignalHandlers(): void
    {
        if (! function_exists('pcntl_signal') || ! extension_loaded('pcntl')) {
            return;
        }

        $handler = function (): void {
            $this->logger->info('Mattermost WS received shutdown signal');
            $this->disconnect();
        };

        try {
            if (defined('SIGTERM')) {
                $this->loop->addSignal(SIGTERM, $handler);
            }
            if (defined('SIGINT')) {
                $this->loop->addSignal(SIGINT, $handler);
            }
        } catch (Throwable $error) {
            // Some loops (e.g. StreamSelectLoop without pcntl) reject
            // signal registration. Logged + ignored — Ctrl-C will still
            // kill the process, just without graceful close.
            $this->logger->debug('Mattermost WS signal handlers unavailable', [
                'error' => $error->getMessage(),
            ]);
        }
    }
}
