<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Filament\Pages;

use BackedEnum;
use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\MattermostManager;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use Throwable;

/**
 * Read-only log of recent posts the bot can see in a watched channel.
 *
 * The bot framework (issue #4) does not yet have a backing store, so this
 * page intentionally pulls live posts from the configured "watch" channel
 * via the Saloon client. When no channel is configured, the page renders
 * an empty state with guidance.
 *
 * Filters: a `channel` query string lets the user override the watch channel
 * at runtime; date filters happen client-side on the rendered list.
 */
class MessageLog extends Page
{
    protected static string|BackedEnum|null $navigationIcon = Heroicon::ChatBubbleBottomCenterText;

    protected static ?string $navigationLabel = 'Message log';

    protected static ?string $title = 'Message log';

    protected static ?int $navigationSort = 20;

    protected string $view = 'mattermost::filament.pages.message-log';

    public ?string $channelId = null;

    public ?string $sinceDate = null;

    public function mount(): void
    {
        $this->channelId ??= self::defaultChannelId();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    #[\Override]
    public function getMessages(): array
    {
        if (! is_string($this->channelId) || $this->channelId === '') {
            return [];
        }

        try {
            $response = $this->mattermost()->posts()->getPostsForChannel($this->channelId);

            if (! $response->successful()) {
                return [];
            }

            /** @var array<string, mixed> $payload */
            $payload = $response->json();
            /** @var array<int, string> $order */
            $order = is_array($payload['order'] ?? null) ? $payload['order'] : [];
            /** @var array<string, array<string, mixed>> $posts */
            $posts = is_array($payload['posts'] ?? null) ? $payload['posts'] : [];

            $messages = [];

            foreach ($order as $postId) {
                $post = $posts[$postId] ?? null;

                if (! is_array($post)) {
                    continue;
                }

                if ($this->isFilteredOut($post)) {
                    continue;
                }

                $messages[] = $this->normalizePost($post);
            }

            return $messages;
        } catch (Throwable) {
            return [];
        }
    }

    /**
     * @return array<string, mixed>
     */
    #[\Override]
    protected function getViewData(): array
    {
        return [
            'messages' => $this->getMessages(),
            'channelId' => $this->channelId,
            'sinceDate' => $this->sinceDate,
        ];
    }

    /**
     * @param  array<string, mixed>  $post
     * @return array<string, mixed>
     */
    private function normalizePost(array $post): array
    {
        $createAt = is_int($post['create_at'] ?? null) ? $post['create_at'] : 0;

        return [
            'id' => is_string($post['id'] ?? null) ? $post['id'] : '',
            'channel_id' => is_string($post['channel_id'] ?? null) ? $post['channel_id'] : '',
            'user_id' => is_string($post['user_id'] ?? null) ? $post['user_id'] : '',
            'message' => is_string($post['message'] ?? null) ? $post['message'] : '',
            'root_id' => is_string($post['root_id'] ?? null) ? $post['root_id'] : '',
            'created_at_ms' => $createAt,
            'created_at_iso' => $createAt > 0 ? gmdate('c', intdiv($createAt, 1000)) : '',
        ];
    }

    /**
     * @param  array<string, mixed>  $post
     */
    private function isFilteredOut(array $post): bool
    {
        if ($this->sinceDate === null || $this->sinceDate === '') {
            return false;
        }

        $cutoff = strtotime($this->sinceDate);

        if ($cutoff === false) {
            return false;
        }

        $createAt = is_int($post['create_at'] ?? null) ? intdiv($post['create_at'], 1000) : 0;

        return $createAt < $cutoff;
    }

    private function mattermost(): Mattermost
    {
        return app(MattermostManager::class)->connection();
    }

    public static function defaultChannelId(): ?string
    {
        $value = config('mattermost.filament.watch_channel_id');

        return is_string($value) && $value !== '' ? $value : null;
    }
}
