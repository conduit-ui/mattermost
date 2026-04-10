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

    'connections' => [
        'default' => [
            'url' => env('MATTERMOST_URL', 'http://localhost:8065'),
            'token' => env('MATTERMOST_BOT_TOKEN'),
            'bot_user_id' => env('MATTERMOST_BOT_USER_ID'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Bot Settings
    |--------------------------------------------------------------------------
    */

    'bot' => [
        'dedup_ttl' => env('MATTERMOST_DEDUP_TTL', 60),
        'rate_limit_seconds' => env('MATTERMOST_RATE_LIMIT', 30),
        'ignore_bots' => true,
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
