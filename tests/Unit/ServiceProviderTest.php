<?php

it('registers the service provider', function (): void {
    expect(config('mattermost.default'))->toBe('default');
});

it('loads default connection config', function (): void {
    expect(config('mattermost.connections.default.url'))->toBe('http://localhost:8065');
    expect(config('mattermost.connections.default.token'))->toBe('test-token');
});

it('loads bot config', function (): void {
    expect(config('mattermost.bot.dedup_ttl'))->toBe(60);
    expect(config('mattermost.bot.rate_limit_seconds'))->toBe(30);
});

it('loads websocket config', function (): void {
    expect(config('mattermost.websocket.reconnect_max_delay'))->toBe(60);
    expect(config('mattermost.websocket.ping_interval'))->toBe(30);
});
