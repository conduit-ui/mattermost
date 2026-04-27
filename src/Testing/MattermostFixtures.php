<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Testing;

/**
 * Static factories that produce realistic Mattermost API JSON shapes for
 * use in tests. Every helper accepts a partial array of overrides and merges
 * it on top of sensible defaults.
 */
class MattermostFixtures
{
    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function post(array $overrides = []): array
    {
        $now = (int) (microtime(true) * 1000);

        return array_merge([
            'id' => self::id(),
            'create_at' => $now,
            'update_at' => $now,
            'edit_at' => 0,
            'delete_at' => 0,
            'is_pinned' => false,
            'user_id' => self::id(),
            'channel_id' => self::id(),
            'root_id' => '',
            'original_id' => '',
            'message' => 'hello world',
            'type' => '',
            'props' => (object) [],
            'hashtags' => '',
            'pending_post_id' => '',
            'reply_count' => 0,
            'last_reply_at' => 0,
            'participants' => null,
            'metadata' => (object) [],
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function user(array $overrides = []): array
    {
        $now = (int) (microtime(true) * 1000);

        return array_merge([
            'id' => self::id(),
            'create_at' => $now,
            'update_at' => $now,
            'delete_at' => 0,
            'username' => 'testuser',
            'first_name' => 'Test',
            'last_name' => 'User',
            'nickname' => '',
            'email' => 'test@example.com',
            'auth_data' => '',
            'auth_service' => '',
            'roles' => 'system_user',
            'locale' => 'en',
            'is_bot' => false,
            'timezone' => [
                'automaticTimezone' => 'UTC',
                'manualTimezone' => '',
                'useAutomaticTimezone' => 'true',
            ],
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function channel(array $overrides = []): array
    {
        $now = (int) (microtime(true) * 1000);

        return array_merge([
            'id' => self::id(),
            'create_at' => $now,
            'update_at' => $now,
            'delete_at' => 0,
            'team_id' => self::id(),
            'type' => 'O',
            'display_name' => 'Town Square',
            'name' => 'town-square',
            'header' => '',
            'purpose' => '',
            'last_post_at' => $now,
            'total_msg_count' => 0,
            'extra_update_at' => 0,
            'creator_id' => self::id(),
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function team(array $overrides = []): array
    {
        $now = (int) (microtime(true) * 1000);

        return array_merge([
            'id' => self::id(),
            'create_at' => $now,
            'update_at' => $now,
            'delete_at' => 0,
            'display_name' => 'Test Team',
            'name' => 'test-team',
            'description' => '',
            'email' => 'admin@example.com',
            'type' => 'O',
            'company_name' => '',
            'allowed_domains' => '',
            'invite_id' => self::id(),
            'allow_open_invite' => true,
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function reaction(array $overrides = []): array
    {
        $now = (int) (microtime(true) * 1000);

        return array_merge([
            'user_id' => self::id(),
            'post_id' => self::id(),
            'emoji_name' => 'thumbsup',
            'create_at' => $now,
        ], $overrides);
    }

    /**
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    public static function fileInfo(array $overrides = []): array
    {
        $now = (int) (microtime(true) * 1000);

        return array_merge([
            'id' => self::id(),
            'user_id' => self::id(),
            'post_id' => self::id(),
            'create_at' => $now,
            'update_at' => $now,
            'delete_at' => 0,
            'name' => 'example.txt',
            'extension' => 'txt',
            'size' => 12,
            'mime_type' => 'text/plain',
            'has_preview_image' => false,
        ], $overrides);
    }

    /**
     * Build a full WebSocket event envelope.
     *
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $broadcast
     * @return array<string, mixed>
     */
    public static function websocketEvent(string $event, array $data = [], array $broadcast = []): array
    {
        return [
            'event' => $event,
            'data' => $data,
            'broadcast' => array_merge([
                'omit_users' => null,
                'user_id' => '',
                'channel_id' => '',
                'team_id' => '',
            ], $broadcast),
            'seq' => 1,
        ];
    }

    /**
     * Build a "posted" WebSocket event for an incoming direct message.
     *
     * @return array<string, mixed>
     */
    public static function fakeDirectMessage(string $text, ?string $userId = null, ?string $channelId = null): array
    {
        $userId ??= self::id();
        $channelId ??= self::id();

        $post = self::post([
            'message' => $text,
            'user_id' => $userId,
            'channel_id' => $channelId,
        ]);

        return self::websocketEvent('posted', [
            'channel_display_name' => '@'.($post['user_id']),
            'channel_name' => 'direct-message',
            'channel_type' => 'D',
            'post' => json_encode($post),
            'sender_name' => '@testuser',
            'team_id' => '',
            'set_online' => true,
        ], [
            'channel_id' => $channelId,
            'user_id' => '',
        ]);
    }

    /**
     * Build a "posted" WebSocket event for a channel message that mentions the bot.
     *
     * @return array<string, mixed>
     */
    public static function fakeMention(string $text, ?string $channelId = null, ?string $userId = null, string $botUsername = 'bot'): array
    {
        $userId ??= self::id();
        $channelId ??= self::id();

        $post = self::post([
            'message' => $text,
            'user_id' => $userId,
            'channel_id' => $channelId,
        ]);

        return self::websocketEvent('posted', [
            'channel_display_name' => 'Town Square',
            'channel_name' => 'town-square',
            'channel_type' => 'O',
            'mentions' => json_encode([$botUsername]),
            'post' => json_encode($post),
            'sender_name' => '@testuser',
            'team_id' => self::id(),
            'set_online' => true,
        ], [
            'channel_id' => $channelId,
        ]);
    }

    /**
     * Build a "posted" WebSocket event representing a file share.
     *
     * @param  array<int, string>  $fileIds
     * @return array<string, mixed>
     */
    public static function fakeFileShare(array $fileIds, ?string $channelId = null, ?string $userId = null, string $message = ''): array
    {
        $userId ??= self::id();
        $channelId ??= self::id();

        $post = self::post([
            'message' => $message,
            'user_id' => $userId,
            'channel_id' => $channelId,
            'file_ids' => $fileIds,
            'type' => '',
        ]);

        return self::websocketEvent('posted', [
            'channel_display_name' => 'Town Square',
            'channel_name' => 'town-square',
            'channel_type' => 'O',
            'post' => json_encode($post),
            'sender_name' => '@testuser',
            'team_id' => self::id(),
            'set_online' => true,
        ], [
            'channel_id' => $channelId,
        ]);
    }

    /**
     * Build a Mattermost slash-command HTTP payload — what an outgoing slash
     * command webhook would deliver.
     *
     * @return array<string, mixed>
     */
    public static function fakeSlashCommand(string $command, string $text = '', ?string $userId = null, ?string $channelId = null): array
    {
        return [
            'token' => 'slash-command-token',
            'team_id' => self::id(),
            'team_domain' => 'test-team',
            'channel_id' => $channelId ?? self::id(),
            'channel_name' => 'town-square',
            'user_id' => $userId ?? self::id(),
            'user_name' => 'testuser',
            'command' => str_starts_with($command, '/') ? $command : '/'.$command,
            'text' => $text,
            'response_url' => 'https://example.com/hooks/commands/'.self::id(),
            'trigger_id' => self::id(),
        ];
    }

    /**
     * Build the payload Mattermost POSTs when a user clicks an interactive
     * button or selects a menu option.
     *
     * @param  array<string, mixed>  $context
     * @return array<string, mixed>
     */
    public static function fakeButtonClick(string $actionId, mixed $value = null, array $context = [], ?string $userId = null, ?string $channelId = null, ?string $postId = null): array
    {
        return [
            'user_id' => $userId ?? self::id(),
            'user_name' => 'testuser',
            'channel_id' => $channelId ?? self::id(),
            'channel_name' => 'town-square',
            'team_id' => self::id(),
            'team_domain' => 'test-team',
            'post_id' => $postId ?? self::id(),
            'trigger_id' => self::id(),
            'type' => 'button',
            'data_source' => '',
            'context' => array_merge(
                ['action' => $actionId],
                $value !== null ? ['value' => $value] : [],
                $context,
            ),
        ];
    }

    /**
     * Generate a 26-character lowercase ID similar to a Mattermost cuid.
     */
    public static function id(): string
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $id = '';

        for ($i = 0; $i < 26; $i++) {
            $id .= $alphabet[random_int(0, strlen($alphabet) - 1)];
        }

        return $id;
    }
}
