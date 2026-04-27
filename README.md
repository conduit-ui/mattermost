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

## Try it

Post a message to any channel from the command line:

```bash
# Set your connection details in .env
MATTERMOST_URL=http://localhost:8065
MATTERMOST_BOT_TOKEN=your-bot-token
MATTERMOST_TEAM=your-team-name

# Post to the default channel (town-square)
php artisan mattermost:demo-post

# Post to a specific channel with a custom message
php artisan mattermost:demo-post general "Deployed v2.0 🚀"

# Override the team name
php artisan mattermost:demo-post town-square "Hello!" --team=other-team
```

## License

MIT
