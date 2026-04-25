<?php

declare(strict_types=1);

use ConduitUI\Mattermost\WebSocket\Events\ChannelViewed;
use ConduitUI\Mattermost\WebSocket\Events\EventFactory;
use ConduitUI\Mattermost\WebSocket\Events\GenericEvent;
use ConduitUI\Mattermost\WebSocket\Events\Hello;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use ConduitUI\Mattermost\WebSocket\Events\PostDeleted;
use ConduitUI\Mattermost\WebSocket\Events\PostEdited;
use ConduitUI\Mattermost\WebSocket\Events\ReactionAdded;
use ConduitUI\Mattermost\WebSocket\Events\ReactionRemoved;
use ConduitUI\Mattermost\WebSocket\Events\Typing;
use ConduitUI\Mattermost\WebSocket\Events\UserStatusChanged;

describe('EventFactory', function (): void {
    it('returns null for malformed JSON', function (): void {
        expect(EventFactory::fromJson('not json'))->toBeNull();
    });

    it('returns null for an action ack (no event field)', function (): void {
        $frame = json_encode(['status' => 'OK', 'seq_reply' => 1]);
        expect(EventFactory::fromJson($frame))->toBeNull();
    });

    it('parses a `posted` event into PostCreated and decodes the nested post', function (): void {
        $frame = [
            'event' => 'posted',
            'data' => [
                'channel_type' => 'D',
                'channel_name' => 'lexi__jordan',
                'sender_name' => '@jordan',
                'post' => json_encode([
                    'id' => 'p1',
                    'channel_id' => 'c1',
                    'user_id' => 'u1',
                    'message' => 'hi lexi',
                    'root_id' => '',
                ]),
            ],
            'broadcast' => ['channel_id' => 'c1'],
            'seq' => 42,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(PostCreated::class);
        expect($event->name())->toBe('posted');
        expect($event->seq)->toBe(42);
        expect($event->channelId())->toBe('c1');
        expect($event->channelType())->toBe('D');
        expect($event->senderName())->toBe('@jordan');
        expect($event->userId())->toBe('u1');
        expect($event->message())->toBe('hi lexi');
        expect($event->rootId())->toBe('');
    });

    it('parses a `post_edited` event', function (): void {
        $frame = [
            'event' => 'post_edited',
            'data' => [
                'post' => json_encode([
                    'id' => 'p2',
                    'channel_id' => 'c2',
                    'user_id' => 'u2',
                    'message' => 'edited message',
                ]),
            ],
            'broadcast' => [],
            'seq' => 1,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(PostEdited::class);
        expect($event->postId())->toBe('p2');
        expect($event->channelId())->toBe('c2');
        expect($event->userId())->toBe('u2');
        expect($event->message())->toBe('edited message');
    });

    it('parses a `post_deleted` event', function (): void {
        $frame = [
            'event' => 'post_deleted',
            'data' => [
                'post' => json_encode([
                    'id' => 'p3',
                    'channel_id' => 'c3',
                    'user_id' => 'u3',
                ]),
            ],
            'broadcast' => [],
            'seq' => 2,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(PostDeleted::class);
        expect($event->postId())->toBe('p3');
    });

    it('parses a `typing` event with the channel id from broadcast', function (): void {
        $frame = [
            'event' => 'typing',
            'data' => ['user_id' => 'u4', 'parent_id' => ''],
            'broadcast' => ['channel_id' => 'c4'],
            'seq' => 3,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(Typing::class);
        expect($event->userId())->toBe('u4');
        expect($event->channelId())->toBe('c4');
    });

    it('parses `reaction_added` and decodes the nested reaction', function (): void {
        $frame = [
            'event' => 'reaction_added',
            'data' => [
                'reaction' => json_encode([
                    'emoji_name' => 'white_check_mark',
                    'post_id' => 'p5',
                    'user_id' => 'u5',
                ]),
            ],
            'broadcast' => ['channel_id' => 'c5'],
            'seq' => 4,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(ReactionAdded::class);
        expect($event->emoji())->toBe('white_check_mark');
        expect($event->postId())->toBe('p5');
        expect($event->userId())->toBe('u5');
        expect($event->channelId())->toBe('c5');
    });

    it('parses `reaction_removed`', function (): void {
        $frame = [
            'event' => 'reaction_removed',
            'data' => [
                'reaction' => json_encode([
                    'emoji_name' => '+1',
                    'post_id' => 'p6',
                    'user_id' => 'u6',
                ]),
            ],
            'broadcast' => [],
            'seq' => 5,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(ReactionRemoved::class);
        expect($event->emoji())->toBe('+1');
    });

    it('parses `channel_viewed`', function (): void {
        $frame = [
            'event' => 'channel_viewed',
            'data' => ['channel_id' => 'c7'],
            'broadcast' => ['user_id' => 'u7'],
            'seq' => 6,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(ChannelViewed::class);
        expect($event->channelId())->toBe('c7');
        expect($event->userId())->toBe('u7');
    });

    it('parses `status_change` into UserStatusChanged', function (): void {
        $frame = [
            'event' => 'status_change',
            'data' => ['user_id' => 'u8', 'status' => 'online'],
            'broadcast' => [],
            'seq' => 7,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(UserStatusChanged::class);
        expect($event->userId())->toBe('u8');
        expect($event->status())->toBe('online');
    });

    it('parses `hello`', function (): void {
        $frame = [
            'event' => 'hello',
            'data' => ['server_version' => '9.5.0'],
            'broadcast' => [],
            'seq' => 0,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(Hello::class);
        expect($event->serverVersion())->toBe('9.5.0');
    });

    it('falls back to GenericEvent for unknown events', function (): void {
        $frame = [
            'event' => 'something_brand_new',
            'data' => ['foo' => 'bar'],
            'broadcast' => ['team_id' => 't1'],
            'seq' => 99,
        ];

        $event = EventFactory::fromArray($frame);

        expect($event)->toBeInstanceOf(GenericEvent::class);
        expect($event->name())->toBe('something_brand_new');
        expect($event->data)->toBe(['foo' => 'bar']);
        expect($event->broadcast)->toBe(['team_id' => 't1']);
        expect($event->seq)->toBe(99);
    });

    it('round-trips fromJson for a real frame string', function (): void {
        $raw = json_encode([
            'event' => 'hello',
            'data' => ['server_version' => '9.5.0'],
            'broadcast' => [],
            'seq' => 0,
        ]);

        expect(EventFactory::fromJson($raw))->toBeInstanceOf(Hello::class);
    });
});
