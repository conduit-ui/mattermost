<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\Streaming\MattermostStreamingReply;

describe('Streaming integration', function (): void {
    it('drives MattermostStreamingReply against a real channel — create then update flow', function (): void {
        $channelId = $this->credentials()->channelId;
        $client = $this->client();

        $reply = new MattermostStreamingReply($client, $channelId);

        // First chunk → real createPost.
        $reply->onFirstContent('integration: streaming chunk 1');
        $postId = $reply->postId();

        expect($postId)->toBeString();

        // Subsequent chunk → real updatePost (HasBody is required for the
        // body to actually reach the server — this test fails loudly if the
        // UpdatePost request loses its body).
        $reply->onText('integration: streaming chunk 1 chunk 2');

        $fetched = Mattermost::posts()->getPost($postId);
        expect($fetched->status())->toBe(200);
        expect($fetched->json('message'))->toBe('integration: streaming chunk 1 chunk 2');

        // Completion finalises — body should match the final text.
        $reply->onComplete('integration: streaming final');

        $final = Mattermost::posts()->getPost($postId);
        expect($final->json('message'))->toBe('integration: streaming final');
    });

    it('renders a tool-call status line beneath the body without clobbering it', function (): void {
        $channelId = $this->credentials()->channelId;
        $client = $this->client();

        $reply = new MattermostStreamingReply($client, $channelId);

        $reply->onFirstContent('thinking');
        $reply->onToolCall('search_web');

        $postId = $reply->postId();
        expect($postId)->toBeString();

        $fetched = Mattermost::posts()->getPost($postId);
        expect($fetched->json('message'))->toContain('thinking');
        expect($fetched->json('message'))->toContain('_search_web_');
    });
});
