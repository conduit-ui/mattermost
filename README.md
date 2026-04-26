# Mattermost for Laravel

The Laravel way to build Mattermost bots.

> **Status:** Under active development. Not yet published on Packagist.

## Features

- Saloon-based REST client for Mattermost API v4
- WebSocket client with auto-reconnect
- Event-driven bot framework with middleware
- Streaming replies
- Slash command routing
- Interactive messages
- Laravel notifications + broadcasting
- Filament admin panel
- First-class testing utilities

## Requirements

- PHP 8.4+
- Laravel 13+

## Installation

```bash
composer require conduit-ui/mattermost
```

## Quick Start

```bash
php artisan vendor:publish --tag=mattermost-config
```

Set your credentials in `.env`:

```dotenv
MATTERMOST_URL=https://your-server.example.com
MATTERMOST_BOT_TOKEN=your-bot-token
```

```php
use ConduitUI\Mattermost\Facades\Mattermost;

Mattermost::post('town-square', 'Hello from Laravel!');
```

## License

MIT
