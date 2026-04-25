<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Posts\UpdatePost;
use ConduitUI\Mattermost\Streaming\MattermostStreamingReply;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

function streamingHarness(?string $rootId = null): array
{
    $mattermost = new Mattermost(baseUrl: 'http://localhost:8065', token: 'test-token');

    $mock = new MockClient([
        CreatePost::class => MockResponse::make(['id' => 'post_abc']),
        UpdatePost::class => MockResponse::make(['id' => 'post_abc']),
    ]);

    $mattermost->withMockClient($mock);

    $reply = new MattermostStreamingReply($mattermost, channelId: 'ch_123', rootId: $rootId);

    return [$mattermost, $mock, $reply];
}

describe('MattermostStreamingReply', function (): void {
    it('lazily creates a post on first content with channel and message', function (): void {
        [, $mock, $reply] = streamingHarness();

        $reply->onFirstContent('hello world');

        expect($reply->postId())->toBe('post_abc');
        expect($mock->getRecordedResponses())->toHaveCount(1);

        $request = $mock->getLastRequest();
        expect($request)->toBeInstanceOf(CreatePost::class);
        expect($request?->body()->all())->toMatchArray([
            'channel_id' => 'ch_123',
            'message' => 'hello world',
        ]);
    });

    it('passes the root_id when threading', function (): void {
        [, $mock, $reply] = streamingHarness(rootId: 'root_999');

        $reply->onFirstContent('threaded reply');

        $body = $mock->getLastRequest()?->body()->all();
        expect($body)->toMatchArray([
            'channel_id' => 'ch_123',
            'message' => 'threaded reply',
            'root_id' => 'root_999',
        ]);
    });

    it('updates the existing post on subsequent onText calls', function (): void {
        [, $mock, $reply] = streamingHarness();

        $reply->onFirstContent('first');
        $reply->onText('first more');

        expect($mock->getRecordedResponses())->toHaveCount(2);

        $request = $mock->getLastRequest();
        expect($request)->toBeInstanceOf(UpdatePost::class);
        expect($request?->body()->all())->toMatchArray([
            'id' => 'post_abc',
            'message' => 'first more',
        ]);
    });

    it('keeps the body intact when a tool call fires mid-stream', function (): void {
        [, $mock, $reply] = streamingHarness();

        $reply->onFirstContent('Here is the answer');
        $reply->onToolCall('MemorySearch');

        $request = $mock->getLastRequest();
        expect($request)->toBeInstanceOf(UpdatePost::class);

        $message = $request?->body()->all()['message'] ?? '';
        expect($message)->toStartWith('Here is the answer');
        expect($message)->toContain('MemorySearch');
    });

    it('lazily creates a post when only a tool call has fired', function (): void {
        [, $mock, $reply] = streamingHarness();

        $reply->onToolCall('MemorySearch');

        expect($reply->postId())->toBe('post_abc');

        $request = $mock->getLastRequest();
        expect($request)->toBeInstanceOf(CreatePost::class);
        expect($request?->body()->all()['message'])->toContain('MemorySearch');
    });

    it('finalizes with onComplete by clearing the status and writing final text', function (): void {
        [, $mock, $reply] = streamingHarness();

        $reply->onFirstContent('partial');
        $reply->onToolCall('MemorySearch');
        $reply->onComplete('partial then the full answer');

        $request = $mock->getLastRequest();
        expect($request)->toBeInstanceOf(UpdatePost::class);
        expect($request?->body()->all()['message'])->toBe('partial then the full answer');
    });

    it('skips API calls entirely when onComplete is called with empty text and no prior post', function (): void {
        [, $mock, $reply] = streamingHarness();

        $reply->onComplete('');

        expect($reply->postId())->toBeNull();
        expect($mock->getRecordedResponses())->toBeEmpty();
    });

    it('handles short replies that bypass onFirstContent and complete directly', function (): void {
        [, $mock, $reply] = streamingHarness();

        // Mimic StreamCollector behavior for short replies: onFirstContent
        // fires before onComplete with the same text.
        $reply->onFirstContent('hi');
        $reply->onComplete('hi');

        expect($reply->postId())->toBe('post_abc');
        $request = $mock->getLastRequest();
        expect($request)->toBeInstanceOf(UpdatePost::class);
        expect($request?->body()->all()['message'])->toBe('hi');
    });
});
