# Mattermost for Laravel

[![CI](https://img.shields.io/github/actions/workflow/status/conduit-ui/mattermost/ci.yml?branch=main&label=CI&logo=github)](https://github.com/conduit-ui/mattermost/actions/workflows/ci.yml)
[![PHP](https://img.shields.io/badge/PHP-%5E8.4-777BB4?logo=php&logoColor=white)](https://php.net)
[![Laravel](https://img.shields.io/badge/Laravel-%5E13-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![Saloon](https://img.shields.io/badge/Saloon-%5E4-008080)](https://docs.saloon.dev)
[![Pest](https://img.shields.io/badge/tested%20with-Pest-8B5CF6?logo=php)](https://pestphp.com)
[![PHPStan](https://img.shields.io/badge/PHPStan-level%208-brightgreen)](https://phpstan.org)
[![License](https://img.shields.io/github/license/conduit-ui/mattermost)](LICENSE)

The Laravel way to build Mattermost bots.

> **Status:** Under active development. Not yet published on Packagist.

## Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Configuration](#configuration)
- [Quick start](#quick-start)
- [REST API client](#rest-api-client)
- [Sending messages](#sending-messages)
- [Bot framework](#bot-framework)
- [Slash commands](#slash-commands)
- [Interactive messages](#interactive-messages)
- [Streaming replies](#streaming-replies)
- [Notifications](#notifications)
- [Filament panel](#filament-panel)
- [Artisan commands](#artisan-commands)
- [Testing](#testing)
- [Multi-server](#multi-server)
- [Local development](#local-development)
- [License](#license)

## Features

- Saloon-based REST client covering the full Mattermost API v4
- WebSocket client with auto-reconnect, typed events, and signal handling
- Event-driven bot framework — class-based handlers, middleware pipeline, queueable
- Permission guards — role, permission, channel-membership middleware
- Slash command routing
- Interactive messages — buttons, menus, action handlers
- Streaming replies — observer-driven create → edit → finalize flow
- Fluent message builder with attachments, threading, file uploads
- Laravel notification channel + broadcast driver
- Filament admin panel for status, message log, health
- Artisan commands — `mattermost:listen`, `mattermost:post`, `mattermost:health`
- First-class testing — `Mattermost::fake()`, fixture helpers, request assertions
- Multi-server support via named connections

## Requirements

- PHP 8.4+
- Laravel 13+

## Installation

```bash
composer require conduit-ui/mattermost
php artisan vendor:publish --tag=mattermost-config
```

Set the minimum env in your `.env`:

```dotenv
MATTERMOST_URL=https://your-mattermost.example.com
MATTERMOST_BOT_TOKEN=xxxxxxxxxxxxxxxxxxxxxxxxxx
MATTERMOST_TEAM=your-team-name
MATTERMOST_BOT_USER_ID=zzzzzzzzzzzzzzzzzzzzzzzzzz
```

## Configuration

`config/mattermost.php` defines connections, slash commands, bot middleware, and websocket
settings. Most of it has sensible defaults — only `connections` typically needs touching.

```php
return [
    'default' => env('MATTERMOST_CONNECTION', 'default'),

    'connections' => [
        'default' => [
            'url' => env('MATTERMOST_URL', 'http://localhost:8065'),
            'token' => env('MATTERMOST_BOT_TOKEN'),
            'bot_user_id' => env('MATTERMOST_BOT_USER_ID'),
            'team' => env('MATTERMOST_TEAM'),
        ],
    ],

    'bot' => [
        // Global middleware applied to every handler. Per-handler
        // middleware stacks on top via the #[Middleware(...)] attribute.
        'middleware' => [
            ConduitUI\Mattermost\Bot\Middleware\IgnoreBots::class,
            ConduitUI\Mattermost\Bot\Middleware\Dedup::class,
        ],
        'dedup_ttl' => 60,
        'rate_limit_seconds' => 30,
        'allowed_channels' => [],
    ],
];
```

## Quick start

```php
use ConduitUI\Mattermost\Facades\Mattermost;

// One-liner post
Mattermost::posts()->createPost([
    'channel_id' => $channelId,
    'message' => 'Hello from Laravel!',
]);

// Or the fluent builder
use ConduitUI\Mattermost\Messages\Message;

Mattermost::posts()->createPost(
    Message::make('Deploy started')
        ->to($channelId)
        ->thread($rootPostId)
        ->toArray()
);
```

## REST API client

Every Mattermost API v4 endpoint is wrapped in a Saloon resource. Resources are auto-generated
from the OpenAPI spec — every parameter and response is typed.

```php
Mattermost::posts()->createPost([...]);
Mattermost::posts()->updatePost($postId, ['message' => 'edited']);
Mattermost::posts()->deletePost($postId);

Mattermost::channels()->getChannelByName($teamId, 'town-square');
Mattermost::channels()->getChannelMembers($channelId);

Mattermost::users()->getUserByUsername('alice');
Mattermost::users()->getUserStatus($userId);

Mattermost::reactions()->saveReaction([
    'user_id' => $botUserId,
    'post_id' => $postId,
    'emoji_name' => 'eyes',
]);

Mattermost::files()->uploadFile($channelId, $fileResource);
```

Available resources via the `Mattermost` facade: `posts()`, `channels()`, `users()`, `teams()`,
`files()`, `reactions()`, `bots()`, `webhooks()`, `commands()`, `emoji()`, `status()`, `system()`.

## Sending messages

The fluent `Message` builder produces a payload for `POST /api/v4/posts` without
making any HTTP call — pass the result to `posts()->createPost()`.

```php
use ConduitUI\Mattermost\Messages\Message;
use ConduitUI\Mattermost\Messages\Attachment;

$payload = Message::make('Build complete')
    ->to($channelId)
    ->thread($parentPostId)
    ->attachment(
        Attachment::make()
            ->color('#36a64f')
            ->title('main', 'https://github.com/...')
            ->text('All checks passed in 2m31s.')
            ->field('Branch', 'feat/foo', short: true)
            ->field('Commit', 'abc1234', short: true)
    )
    ->toArray();

Mattermost::posts()->createPost($payload);
```

## Bot framework

Mattermost WebSocket events route through a global + per-handler middleware pipeline
to handler classes resolved from the container.

```php
use App\Mattermost\HandleNewPost;
use ConduitUI\Mattermost\Bot\Events\PostCreated;
use ConduitUI\Mattermost\Facades\Mattermost;

// Class-based handler
Mattermost::on(PostCreated::class, HandleNewPost::class);

// By Mattermost event name
Mattermost::on('posted', HandleNewPost::class);

// Wildcard — every event
Mattermost::on('*', LogAllEvents::class);
```

### Handler classes

```php
use ConduitUI\Mattermost\Bot\Attributes\Middleware;
use ConduitUI\Mattermost\Bot\Events\PostCreated;
use ConduitUI\Mattermost\Bot\Handler;
use ConduitUI\Mattermost\Bot\Middleware\IgnoreBots;
use ConduitUI\Mattermost\Bot\Middleware\RateLimit;

#[Middleware(IgnoreBots::class, RateLimit::class)]
class HandleMentions extends Handler
{
    public function handle(PostCreated $event): void
    {
        $this->reply($event, 'on it');
        $this->react($event, 'eyes');
        $this->typing($event);
    }
}
```

`reply()`, `react()`, and `typing()` come from the base `Handler` class — they pick up the
correct connection, bot user id, and threading rules automatically.

### Middleware

Built-in middleware ships under `ConduitUI\Mattermost\Bot\Middleware`:

| Middleware       | What it does                                                              |
|------------------|---------------------------------------------------------------------------|
| `IgnoreBots`     | Drops events authored by any configured bot user                          |
| `Dedup`          | Cache-locks `channel:post` so duplicate event redeliveries are dropped    |
| `RateLimit`      | Per-channel cooldown between accepted posts. DMs exempt                   |
| `ChannelFilter`  | Allowlist by channel id or name                                           |
| `AdminOnly`      | Requires the post author to be a system/team/channel admin                |

Custom middleware implements the `Middleware` interface:

```php
use ConduitUI\Mattermost\Bot\Events\Event;
use ConduitUI\Mattermost\Bot\Middleware\Middleware;

class StripPrefix implements Middleware
{
    public function handle(Event $event, \Closure $next): mixed
    {
        if ($event instanceof PostCreated) {
            $event->message = ltrim($event->message, '!');
        }

        return $next($event);
    }
}
```

### Guards

Permission-based middleware under `ConduitUI\Mattermost\Bot\Middleware\Guards`:

```php
use ConduitUI\Mattermost\Bot\Attributes\Middleware;
use ConduitUI\Mattermost\Bot\Middleware\Guards\ChannelMember;
use ConduitUI\Mattermost\Bot\Middleware\Guards\RequiresPermission;
use ConduitUI\Mattermost\Bot\Middleware\Guards\RequiresRole;

#[Middleware(RequiresRole::class)]
class DeployHandler extends Handler
{
    public static array $roles = ['system_admin'];

    public function handle(PostCreated $event): void { /* ... */ }
}
```

### Queueable handlers

Handlers implementing `ShouldQueue` are dispatched onto Laravel's queue rather than
running inline:

```php
class HandleHeavyJob extends Handler implements \Illuminate\Contracts\Queue\ShouldQueue
{
    public function handle(PostCreated $event): void { /* ... */ }
}
```

Configure the queue/connection per `config/mattermost.php`:

```php
'bot' => [
    'queue' => 'mattermost',
    'queue_connection' => 'redis',
],
```

## Slash commands

Register slash commands with the same route-style API as event handlers:

```php
use App\Mattermost\DeployHandler;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\SlashCommands\SlashCommand;
use ConduitUI\Mattermost\SlashCommands\SlashCommandResponse;

Mattermost::slash('deploy', DeployHandler::class);

Mattermost::slash('status', fn (SlashCommand $cmd) =>
    SlashCommandResponse::make()->inChannel('All systems go')
);
```

Mattermost POSTs slash command webhooks to `/mattermost/slash/{command}`. The route is
auto-registered when `enable_slash_commands` is true in config.

Inside a handler:

```php
class DeployHandler
{
    public function __invoke(SlashCommand $cmd): SlashCommandResponse
    {
        return SlashCommandResponse::make()
            ->ephemeral("Deploying {$cmd->arg(0)}...");
    }
}
```

## Interactive messages

Buttons and menus on Mattermost messages POST to `/mattermost/interactive` when clicked.
Register handlers for action ids:

```php
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\Interactive\InteractiveAction;
use ConduitUI\Mattermost\Interactive\InteractiveActionResponse;

Mattermost::interactive('approve', fn (InteractiveAction $a) =>
    InteractiveActionResponse::make()->update('Approved!')
);
```

The button itself is built into your post's `attachments`:

```php
Mattermost::posts()->createPost([
    'channel_id' => $channelId,
    'message' => 'Ready to deploy?',
    'props' => ['attachments' => [[
        'text' => 'Choose:',
        'actions' => [
            [
                'id' => 'deploy-approve',
                'name' => 'Approve',
                'type' => 'button',
                'integration' => [
                    'url' => url('/mattermost/interactive'),
                    'context' => ['action' => 'approve', 'env' => 'prod'],
                ],
            ],
        ],
    ]]],
]);
```

The `context` you set on the button is what the DTO surfaces as `$action->context()`,
and `context.action` is what `actionId()` returns.

## Streaming replies

For bots replying with LLM tokens, the streaming layer creates a placeholder, edits it as
chunks arrive, and finalizes:

```php
use ConduitUI\Mattermost\Streaming\MattermostStreamingReply;

$reply = MattermostStreamingReply::create($channelId, rootId: $event->postId);

foreach ($llm->stream($prompt) as $chunk) {
    $reply->append($chunk);
}

$reply->finalize();
```

Behind the scenes: `posts()->createPost()` for the placeholder, batched `updatePost()`
calls debounced to respect rate limits, and a final patch with the full text.

## Notifications

Use Mattermost as a Laravel notification channel:

```php
use ConduitUI\Mattermost\Notifications\MattermostMessage;

class DeployFinished extends Notification
{
    public function via(mixed $notifiable): array
    {
        return ['mattermost'];
    }

    public function toMattermost(mixed $notifiable): MattermostMessage
    {
        return MattermostMessage::make("Deploy of `{$this->ref}` finished")
            ->color('#36a64f')
            ->field('Duration', '2m31s', short: true);
    }
}
```

Route via `routeNotificationFor('mattermost', ...)` on the notifiable, or pass
`['channel' => 'channel-id', 'connection' => 'staging']` to target a specific server.

A broadcast driver is also registered — set `BROADCAST_CONNECTION=mattermost` and
`broadcast()->channel('mattermost:channel-id')` posts to Mattermost.

## Filament panel

Auto-discovered Filament pages give you a status dashboard, message log, and health
check inside your existing Filament admin:

```php
// In your PanelProvider
use ConduitUI\Mattermost\Filament\MattermostPlugin;

return $panel->plugin(MattermostPlugin::make());
```

Pages: **Dashboard** (connection + recent activity), **Health** (per-connection ping +
latency), **Message Log** (recent posts).

## Artisan commands

```bash
# Start the bot — connects WebSocket, dispatches events through the router
php artisan mattermost:listen

# One-off post from CLI
php artisan mattermost:post town-square "Deploy underway"

# Connectivity / auth check
php artisan mattermost:health
```

`mattermost:listen` handles SIGTERM/SIGINT cleanly; running it under supervisord or systemd
is the recommended path.

## Testing

`Mattermost::fake()` swaps the underlying client for an in-memory recorder. No HTTP, no
network — every API call is captured for assertions.

```php
use ConduitUI\Mattermost\Facades\Mattermost;

beforeEach(fn () => Mattermost::fake());

it('posts an announcement when deploy finishes', function () {
    DeployFinished::dispatch($build);

    Mattermost::assertPosted(fn ($payload) =>
        $payload['channel_id'] === 'town-square'
        && str_contains($payload['message'], 'Deploy of')
    );
    Mattermost::assertPostCount(1);
});
```

Available assertions: `assertSent`, `assertNotSent`, `assertNothingSent`, `assertPosted`,
`assertNotPosted`, `assertNothingPosted`, `assertPostCount`, `assertUpdated`, `assertPatched`,
`assertDeleted`, `assertReacted`, `assertNotReacted`, `assertFileUploaded`,
`preventStrayPosts`, `recorded`.

Fixture helpers under `MattermostFixtures` build realistic payloads for tests:

```php
use ConduitUI\Mattermost\Testing\MattermostFixtures;

$post = MattermostFixtures::post(['message' => 'hello']);
$wsEvent = MattermostFixtures::websocketEvent('posted', ['post' => $post]);
$buttonClick = MattermostFixtures::fakeButtonClick('approve', context: ['env' => 'prod']);
```

## Multi-server

Define multiple connections in `config/mattermost.php`:

```php
'connections' => [
    'default' => [...],
    'staging' => [
        'url' => env('MATTERMOST_STAGING_URL'),
        'token' => env('MATTERMOST_STAGING_TOKEN'),
    ],
],
```

Pick the connection per call:

```php
Mattermost::connection('staging')->posts()->createPost([...]);
```

## Local development

A `docker-compose.yml` ships a local Mattermost for development:

```bash
docker compose up -d         # start
docker compose down          # stop
```

After the first boot, create an admin via `mmctl` or the web UI at `localhost:8065`,
generate a bot token, and drop it into your `.env`.

The integration test suite runs against the live container:

```bash
vendor/bin/pest --testsuite=Integration
```

## License

MIT
