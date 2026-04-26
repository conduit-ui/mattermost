<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection
    |--------------------------------------------------------------------------
    |
    | The default Mattermost connection to use. This should correspond to one
    | of the connections defined in the "connections" array below.
    |
    */

    'default' => env('MATTERMOST_CONNECTION', 'default'),

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | Named Mattermost server connections. Each connection needs a URL and
    | bot token at minimum. Add multiple for multi-server support.
    |
    */

    'url' => env('MATTERMOST_URL', 'http://localhost:8065'),

    'token' => env('MATTERMOST_BOT_TOKEN'),

    'team_id' => env('MATTERMOST_TEAM_ID'),

    'bot_user_id' => env('MATTERMOST_BOT_USER_ID'),

    /*
    |--------------------------------------------------------------------------
    | Slash Commands
    |--------------------------------------------------------------------------
    |
    | Toggle slash-command support and define registered commands.
    |
    */

    'enable_slash_commands' => env('MATTERMOST_ENABLE_SLASH_COMMANDS', false),

    'slash_commands' => [
        // 'greet' => \App\Mattermost\Commands\GreetCommand::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Connections
    |--------------------------------------------------------------------------
    |
    | Named Mattermost server connections. Each connection needs a URL and
    | bot token at minimum. Add multiple for multi-server support.
    |
    */

    'connections' => [
        'default' => [
            'url' => env('MATTERMOST_URL', 'http://localhost:8065'),
            'token' => env('MATTERMOST_BOT_TOKEN'),
            'bot_user_id' => env('MATTERMOST_BOT_USER_ID'),
            'team' => env('MATTERMOST_TEAM'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bot Settings
    |--------------------------------------------------------------------------
    |
    | Tunables for the bot framework's router and built-in middleware.
    |
    | - `middleware`: global middleware applied to every handler. Listed by
    |   FQCN. Per-handler middleware is added on top via the
    |   `#[Middleware(...)]` attribute on the handler class.
    | - `dedup_ttl`: seconds a `channel:post` key is held in cache to drop
    |   duplicate event redeliveries.
    | - `rate_limit_seconds`: per-channel cooldown between accepted posts.
    |   DMs are exempt.
    | - `allowed_channels`: when non-empty, the `ChannelFilter` middleware
    |   only allows events from these channel ids/names.
    | - `admin_cache_ttl`: cache lifetime for `AdminOnly`'s role lookup.
    | - `queue` / `queue_connection`: dispatch ShouldQueue handlers onto a
    |   specific queue/connection. `null` falls back to defaults.
    |
    */

    'bot' => [
        'middleware' => [
            // ConduitUI\Mattermost\Bot\Middleware\IgnoreBots::class,
            // ConduitUI\Mattermost\Bot\Middleware\Dedup::class,
        ],

        'dedup_ttl' => env('MATTERMOST_DEDUP_TTL', 60),
        'rate_limit_seconds' => env('MATTERMOST_RATE_LIMIT', 30),
        'allowed_channels' => [],
        'admin_cache_ttl' => env('MATTERMOST_ADMIN_CACHE_TTL', 300),
        'queue' => env('MATTERMOST_BOT_QUEUE'),
        'queue_connection' => env('MATTERMOST_BOT_QUEUE_CONNECTION'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Slash Commands
    |--------------------------------------------------------------------------
    |
    | Configure the webhook endpoint that Mattermost POSTs to when a user
    | invokes a registered slash command. Set `route` to `null` or `''` to
    | disable the automatic route registration and register your own.
    |
    */

    'slash_commands' => [
        'route' => env('MATTERMOST_SLASH_ROUTE', 'mattermost/slash-command'),
        'middleware' => [],
    ],

    /*
    |--------------------------------------------------------------------------
    | WebSocket
    |--------------------------------------------------------------------------
    */

    'websocket' => [
        'reconnect_max_delay' => env('MATTERMOST_WS_MAX_DELAY', 60),
        'ping_interval' => env('MATTERMOST_WS_PING', 30),
    ],

    /*
    |--------------------------------------------------------------------------
    | Logging
    |--------------------------------------------------------------------------
    */

    'logging' => [
        'channel' => env('MATTERMOST_LOG_CHANNEL', 'mattermost'),
    ],

];
