<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot;

use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use ConduitUI\Mattermost\Client\Requests\Users\PublishUserTyping;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\PostCreated;
use Saloon\Http\Response;

/**
 * Base class for bot event handlers.
 *
 * Subclasses implement `handle()` with a typed event parameter. The router
 * resolves handlers from the container, so DI is fully available.
 *
 *   class HandleMention extends Handler {
 *       public function __construct(private MyService $svc) {}
 *
 *       public function handle(PostCreated $event): void {
 *           $this->reply($event, 'on it');
 *           $this->react($event, 'eyes');
 *       }
 *   }
 *
 * `reply()`, `react()`, and `typing()` post via the configured Mattermost
 * Saloon connector. Override {@see connectionName()} to target a non-default
 * connection.
 */
abstract class Handler
{
    public function __construct(
        protected readonly MattermostManager $mattermost,
    ) {}

    /**
     * The handler entry point. The router invokes this with the matched
     * event. Subclasses are free to type-narrow the parameter.
     */
    abstract public function handle(Event $event): void;

    /**
     * The connection name used by `reply()`, `react()`, and `typing()`.
     * Override in a subclass to target a different Mattermost server.
     */
    protected function connectionName(): ?string
    {
        return null;
    }

    /**
     * Post a reply to the channel that produced `$event`. When the event
     * carries a `rootId`, the reply is threaded under it; pass an explicit
     * `$rootId` to override (e.g. start a new thread by passing `''`).
     */
    protected function reply(Event $event, string $message, ?string $rootId = null): Response
    {
        $resolvedRoot = $rootId ?? $this->resolveThreadRoot($event);

        return $this->mattermost
            ->connection($this->connectionName())
            ->send(new CreatePost(
                channelId: $this->resolveChannelId($event),
                message: $message,
                rootId: $resolvedRoot !== '' ? $resolvedRoot : null,
            ));
    }

    /**
     * React to the post that produced `$event` with the given emoji.
     *
     * @param  string  $emoji  Emoji short name (no colons), e.g. `eyes`, `+1`.
     */
    protected function react(Event $event, string $emoji): Response
    {
        return $this->mattermost
            ->connection($this->connectionName())
            ->send(new SaveReaction(
                userId: $this->resolveBotUserId(),
                postId: $this->resolvePostId($event),
                emojiName: $emoji,
            ));
    }

    /**
     * Publish a "user is typing" indicator into the channel that produced
     * `$event`. The bot's user id is required by Mattermost — set
     * `mattermost.connections.<name>.bot_user_id` in config.
     */
    protected function typing(Event $event): Response
    {
        return $this->mattermost
            ->connection($this->connectionName())
            ->send(new PublishUserTyping(
                userId: $this->resolveBotUserId(),
            ));
    }

    protected function resolveChannelId(Event $event): string
    {
        if ($event instanceof PostCreated) {
            return $event->channelId();
        }

        $broadcast = $event->broadcast;
        $candidate = $broadcast['channel_id'] ?? null;

        return is_string($candidate) ? $candidate : '';
    }

    protected function resolvePostId(Event $event): string
    {
        if ($event instanceof PostCreated) {
            $post = $event->post();
            $id = $post['id'] ?? null;

            return is_string($id) ? $id : '';
        }

        $candidate = $event->data['post_id'] ?? null;

        return is_string($candidate) ? $candidate : '';
    }

    protected function resolveThreadRoot(Event $event): string
    {
        if ($event instanceof PostCreated) {
            $root = $event->rootId();

            return $root !== '' ? $root : $this->resolvePostId($event);
        }

        return '';
    }

    protected function resolveBotUserId(): string
    {
        $name = $this->connectionName() ?? config('mattermost.default', 'default');
        $configured = config(sprintf('mattermost.connections.%s.bot_user_id', $name));

        if (! is_string($configured) || $configured === '') {
            throw new \RuntimeException(sprintf(
                'mattermost.connections.%s.bot_user_id is not configured. Set MATTERMOST_BOT_USER_ID (or the connection-specific equivalent) before calling react() / typing() on a handler.',
                $name,
            ));
        }

        return $configured;
    }
}
