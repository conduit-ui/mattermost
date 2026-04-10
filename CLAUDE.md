# CLAUDE.md

## What This Is

**Mattermost for Laravel** — a package for building Mattermost bots the Laravel way.

- Saloon-based REST client for Mattermost API v4
- WebSocket client with auto-reconnect and exponential backoff
- Event-driven bot framework with handler classes and middleware
- Streaming replies (create → edit → finalize)
- Slash command routing
- Interactive messages (buttons, menus, dialogs)
- Laravel notification channel + broadcast driver
- Filament panel for bot management
- First-class testing with `Mattermost::fake()` and fixture helpers

## Key Commands

```bash
# Tests
vendor/bin/pest --compact

# Code style
vendor/bin/pint --test    # check
vendor/bin/pint           # fix

# Static analysis
vendor/bin/phpstan analyse

# Code hygiene
vendor/bin/rector process --dry-run

# Local Mattermost
docker compose up -d      # start
docker compose down        # stop
```

## Architecture

```
src/
├── Client/           # Saloon connector + API requests (framework-agnostic)
├── WebSocket/        # WS client, reconnect, event parsing
├── Bot/              # Router, handlers, middleware (dedup, rate limit, etc)
├── Streaming/        # StreamObserver + MattermostStreamingReply
├── Messages/         # Fluent message builder, attachments
├── SlashCommands/    # Slash command routing
├── Interactive/      # Button/menu action routing
├── Notifications/    # Laravel notification channel + broadcast driver
├── Filament/         # Admin panel pages (auto-discovered)
├── Commands/         # mattermost:listen, post, health
├── Facades/          # Mattermost facade
├── Testing/          # Fake + fixture helpers
└── MattermostServiceProvider.php
```

## Conventions

- Namespace: `ConduitUI\Mattermost`
- PHP 8.4+ / Laravel 13+
- PHPStan level 8
- Pint with Laravel preset
- Pest with describe/it syntax
- Saloon for all HTTP (not Http facade)
- Named connections for multi-server support

## Testing

```bash
# Unit + Feature (mocked)
vendor/bin/pest

# Integration (requires Docker Mattermost)
docker compose up -d
vendor/bin/pest --testsuite=Integration
```
