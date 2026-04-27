<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Commands;

use ConduitUI\Mattermost\Bot\Router;
use ConduitUI\Mattermost\WebSocket\Client as WebSocketClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ListenCommand extends Command
{
    /** @var string */
    protected $signature = 'mattermost:listen
        {--connection= : The named connection (defaults to mattermost.default)}';

    /** @var string */
    protected $description = 'Start the Mattermost bot WebSocket listener';

    public function handle(Router $router): int
    {
        $connection = $this->connectionName();

        /** @var string $url */
        $url = config("mattermost.connections.{$connection}.url", config('mattermost.url', 'http://localhost:8065'));

        /** @var string $token */
        $token = config("mattermost.connections.{$connection}.token", config('mattermost.token', ''));

        $logChannel = config('mattermost.logging.channel');
        $logger = is_string($logChannel) && $logChannel !== ''
            ? Log::channel($logChannel)
            : Log::driver();

        /** @var int $pingInterval */
        $pingInterval = config('mattermost.websocket.ping_interval', 30);

        $client = new WebSocketClient(
            baseUrl: $url,
            token: $token,
            logger: $logger,
            pingIntervalSeconds: $pingInterval,
        );

        $router->attachToWebSocketClient($client);

        $this->info("Mattermost bot listening on connection [{$connection}]...");
        $this->info("WebSocket URL: {$client->url()}");
        $this->info('Press Ctrl+C to stop.');
        $this->newLine();

        $client->run();

        $this->info('Bot listener stopped.');

        return self::SUCCESS;
    }

    private function connectionName(): string
    {
        /** @var string|null $option */
        $option = $this->option('connection');

        if ($option !== null && $option !== '') {
            return $option;
        }

        /** @var string $default */
        $default = config('mattermost.default', 'default');

        return $default;
    }
}
