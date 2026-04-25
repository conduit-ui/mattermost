<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Notifications;

use ConduitUI\Mattermost\MattermostManager;
use Illuminate\Notifications\Notification;
use RuntimeException;

/**
 * Laravel notification channel that posts to Mattermost.
 *
 * Notifications opt in by implementing a `toMattermost($notifiable)` method that returns
 * either a {@see MattermostMessage} or an array shaped like the JSON body of
 * `POST /api/v4/posts` (e.g. `['channel_id' => '...', 'message' => '...']`).
 *
 * Notifiables route via `routeNotificationFor('mattermost', $notification)`. The route
 * may be either a Mattermost channel id (string) or a config array such as
 * `['channel' => '...', 'connection' => 'staging']` for multi-server setups.
 *
 * If the notification doesn't implement `toMattermost()`, this channel is a no-op.
 */
class MattermostChannel
{
    public function __construct(private readonly MattermostManager $manager) {}

    public function send(mixed $notifiable, Notification $notification): void
    {
        if (! method_exists($notification, 'toMattermost')) {
            return;
        }

        /** @var MattermostMessage|array<string, mixed>|null $payload */
        $payload = $notification->toMattermost($notifiable);

        if ($payload === null) {
            return;
        }

        $route = $this->resolveRoute($notifiable, $notification);

        $message = $this->normalize($payload);

        $channelId = $message['channel_id']
            ?? (is_string($route) ? $route : ($route['channel'] ?? null));

        if ($channelId === null || $channelId === '') {
            throw new RuntimeException(
                'No Mattermost channel id was provided. Set one via routeNotificationFor("mattermost") '
                .'or on the MattermostMessage returned from toMattermost().',
            );
        }

        $connection = $message['connection']
            ?? (is_array($route) ? ($route['connection'] ?? null) : null);

        $this->manager->connection($connection)->posts()->createPost(
            channelId: $channelId,
            message: $message['message'] ?? null,
            rootId: $message['root_id'] ?? null,
            fileIds: $message['file_ids'] ?? null,
            props: $message['props'] ?? null,
        );
    }

    /**
     * @param  MattermostMessage|array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    private function normalize(MattermostMessage|array $payload): array
    {
        if ($payload instanceof MattermostMessage) {
            return array_filter(
                [
                    'channel_id' => $payload->channelId,
                    'message' => $payload->text,
                    'root_id' => $payload->rootId,
                    'file_ids' => $payload->fileIds,
                    'props' => $payload->props,
                    'connection' => $payload->connection,
                ],
                static fn (string|array|null $v): bool => $v !== null,
            );
        }

        return $payload;
    }

    /**
     * @return string|array{channel?: string, connection?: string}|null
     */
    private function resolveRoute(mixed $notifiable, Notification $notification): string|array|null
    {
        if (! is_object($notifiable) || ! method_exists($notifiable, 'routeNotificationFor')) {
            return null;
        }

        /** @var string|array{channel?: string, connection?: string}|null $route */
        $route = $notifiable->routeNotificationFor('mattermost', $notification);

        return $route;
    }
}
