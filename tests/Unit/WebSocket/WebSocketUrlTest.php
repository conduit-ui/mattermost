<?php

declare(strict_types=1);

use ConduitUI\Mattermost\WebSocket\WebSocketUrl;

describe('WebSocketUrl', function (): void {
    it('rewrites http to ws and appends the v4 endpoint', function (): void {
        expect(WebSocketUrl::fromBaseUrl('http://localhost:8065'))
            ->toBe('ws://localhost:8065/api/v4/websocket');
    });

    it('rewrites https to wss', function (): void {
        expect(WebSocketUrl::fromBaseUrl('https://mattermost.example.com'))
            ->toBe('wss://mattermost.example.com/api/v4/websocket');
    });

    it('strips a trailing slash before appending the path', function (): void {
        expect(WebSocketUrl::fromBaseUrl('https://mm.example.com/'))
            ->toBe('wss://mm.example.com/api/v4/websocket');
    });

    it('passes through an already-ws url', function (): void {
        expect(WebSocketUrl::fromBaseUrl('wss://mm.example.com'))
            ->toBe('wss://mm.example.com/api/v4/websocket');
    });

    it('rejects an unsupported scheme', function (): void {
        WebSocketUrl::fromBaseUrl('ftp://mm.example.com');
    })->throws(InvalidArgumentException::class);

    it('rejects an empty url', function (): void {
        WebSocketUrl::fromBaseUrl('');
    })->throws(InvalidArgumentException::class);
});
