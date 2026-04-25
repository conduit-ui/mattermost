<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Notifications;

use ConduitUI\Mattermost\MattermostManager;
use Illuminate\Broadcasting\Broadcasters\Broadcaster;

/**
 * Broadcast driver that publishes Laravel events to Mattermost channels.
 *
 * Events implementing `ShouldBroadcast` are posted as JSON-encoded code blocks to the
 * channel ids returned from `broadcastOn()`. The channel id may be a raw `Channel`
 * name (interpreted as a Mattermost channel id) or a string returned from `formatChannels`.
 *
 * The `connection` option on the broadcasting config selects the named Mattermost
 * connection registered via the package config, supporting multi-server setups.
 */
class MattermostBroadcaster extends Broadcaster
{
    public function __construct(
        private readonly MattermostManager $manager,
        private readonly ?string $connection = null,
    ) {}

    /**
     * {@inheritdoc}
     */
    public function auth($request): void
    {
        // Mattermost broadcasts originate server-side; private-channel auth is not used.
    }

    /**
     * {@inheritdoc}
     */
    public function validAuthenticationResponse($request, $result): void
    {
        // No-op: we never authenticate clients via this driver.
    }

    /**
     * {@inheritdoc}
     *
     * @param  array<int, mixed>  $channels
     * @param  array<string, mixed>  $payload
     */
    public function broadcast(array $channels, $event, array $payload = []): void
    {
        $body = $this->formatBody($event, $payload);

        $client = $this->manager->connection($this->connection);

        foreach ($this->formatChannels($channels) as $channelId) {
            $client->posts()->createPost(
                channelId: $channelId,
                message: $body,
            );
        }
    }

    /**
     * @param  array<string, mixed>  $payload
     */
    private function formatBody(string $event, array $payload): string
    {
        $json = json_encode(
            ['event' => $event, 'payload' => $payload],
            JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
        );

        return "```json\n".($json !== false ? $json : '{}')."\n```";
    }
}
