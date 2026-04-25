<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Bot\Handler;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use ConduitUI\Mattermost\Client\Requests\Users\PublishUserTyping;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\Testing\RecordedRequest;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;

class TestReplyHandler extends Handler
{
    public ?Event $lastEvent = null;

    public ?string $explicitRoot = null;

    #[Override]
    public function handle(Event $event): void
    {
        $this->lastEvent = $event;

        if ($this->explicitRoot !== null) {
            $this->reply($event, 'override-root', $this->explicitRoot);
        } else {
            $this->reply($event, 'hello');
        }

        $this->react($event, 'eyes');
        $this->typing($event);
    }
}

function buildPostEvent(string $channelId = 'channel-abc', string $postId = 'post-123', string $rootId = ''): PostCreated
{
    return new PostCreated(
        data: [
            'post' => json_encode([
                'id' => $postId,
                'channel_id' => $channelId,
                'user_id' => 'user-1',
                'message' => 'ping',
                'root_id' => $rootId,
            ]),
            'channel_type' => 'O',
            'channel_name' => 'general',
            'sender_name' => '@bob',
        ],
        broadcast: ['channel_id' => $channelId],
        seq: 1,
    );
}

describe('Handler', function (): void {
    it('reply() posts to the originating channel and threads under the root post', function (): void {
        $fake = Mattermost::fake();

        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);
        $handler->handle(buildPostEvent(channelId: 'C1', postId: 'P1'));

        $fake->assertPosted(
            fn (RecordedRequest $r): bool => $r->get('channel_id') === 'C1'
                && $r->get('message') === 'hello'
                && $r->get('root_id') === 'P1',
        );
    });

    it('reply() preserves an existing root_id on threaded posts', function (): void {
        $fake = Mattermost::fake();

        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);
        $handler->handle(buildPostEvent(channelId: 'C2', postId: 'P2', rootId: 'thread-root'));

        $fake->assertPosted(
            fn (RecordedRequest $r): bool => $r->get('channel_id') === 'C2'
                && $r->get('root_id') === 'thread-root',
        );
    });

    it('reply() honours an explicit root_id override', function (): void {
        $fake = Mattermost::fake();

        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);
        $handler->explicitRoot = 'manual-root';
        $handler->handle(buildPostEvent(channelId: 'C3', postId: 'P3', rootId: 'thread-root'));

        $fake->assertPosted(
            fn (RecordedRequest $r): bool => $r->get('message') === 'override-root'
                && $r->get('root_id') === 'manual-root',
        );
    });

    it('react() saves a reaction with the bot user id and emoji', function (): void {
        $fake = Mattermost::fake();

        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);
        $handler->handle(buildPostEvent(postId: 'P4'));

        $fake->assertReacted(postId: 'P4', emoji: 'eyes');

        $reaction = $fake->recorded(SaveReaction::class)[0];

        expect($reaction->get('user_id'))->toBe('bot-user-id')
            ->and($reaction->get('post_id'))->toBe('P4')
            ->and($reaction->get('emoji_name'))->toBe('eyes');
    });

    it('typing() publishes a user-typing notification for the bot', function (): void {
        $fake = Mattermost::fake();

        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);
        $handler->handle(buildPostEvent());

        $fake->assertSent(PublishUserTyping::class);
    });

    it('helpers send via the configured connection', function (): void {
        $fake = Mattermost::fake();

        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);
        $handler->handle(buildPostEvent());

        // CreatePost/SaveReaction/PublishUserTyping should all have been
        // captured by the fake recorder.
        expect($fake->recorded(CreatePost::class))->not->toBeEmpty()
            ->and($fake->recorded(SaveReaction::class))->not->toBeEmpty()
            ->and($fake->recorded(PublishUserTyping::class))->not->toBeEmpty();
    });

    it('is resolvable from the container with the manager injected', function (): void {
        /** @var TestReplyHandler $handler */
        $handler = app(TestReplyHandler::class);

        $reflection = new ReflectionClass($handler);
        $property = $reflection->getProperty('mattermost');
        $value = $property->getValue($handler);

        expect($value)->toBeInstanceOf(MattermostManager::class);
    });
});
