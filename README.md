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

```php
// config/mattermost.php is auto-published

// In a service provider or route:
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
