<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\WebSocket\Events;

/**
 * Parses a raw Mattermost WebSocket frame into a typed `Event` value object.
 *
 * Mattermost frames come in three shapes:
 *  - Auth-challenge response: `{ status: "OK", seq_reply: 1 }`
 *  - Server event: `{ event: "...", data: {...}, broadcast: {...}, seq: N }`
 *  - Action reply (response to a client `seq`): `{ seq_reply: N, ... }`
 *
 * `make()` returns `null` for non-event frames (status replies, malformed
 * JSON) so the caller can ignore them without exception handling.
 */
final class EventFactory
{
    /**
     * Map of Mattermost event names to typed event classes.
     *
     * @var array<string, class-string<Event>>
     */
    private const array EVENT_MAP = [
        PostCreated::EVENT_NAME => PostCreated::class,
        PostEdited::EVENT_NAME => PostEdited::class,
        PostDeleted::EVENT_NAME => PostDeleted::class,
        Typing::EVENT_NAME => Typing::class,
        ReactionAdded::EVENT_NAME => ReactionAdded::class,
        ReactionRemoved::EVENT_NAME => ReactionRemoved::class,
        ChannelViewed::EVENT_NAME => ChannelViewed::class,
        UserStatusChanged::EVENT_NAME => UserStatusChanged::class,
        Hello::EVENT_NAME => Hello::class,
    ];

    public static function fromJson(string $raw): ?Event
    {
        $decoded = json_decode($raw, true);

        if (! is_array($decoded)) {
            return null;
        }

        return self::fromArray($decoded);
    }

    /**
     * @param  array<string, mixed>  $frame
     */
    public static function fromArray(array $frame): ?Event
    {
        $event = $frame['event'] ?? null;

        if (! is_string($event) || $event === '') {
            return null;
        }

        $data = is_array($frame['data'] ?? null) ? $frame['data'] : [];
        $broadcast = is_array($frame['broadcast'] ?? null) ? $frame['broadcast'] : [];
        $seq = (int) ($frame['seq'] ?? 0);

        $class = self::EVENT_MAP[$event] ?? null;

        if ($class === null) {
            return new GenericEvent($event, $data, $broadcast, $seq);
        }

        return new $class($data, $broadcast, $seq);
    }
}
