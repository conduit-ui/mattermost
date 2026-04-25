<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Streaming;

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Posts\UpdatePost;

/**
 * Default StreamObserver that renders a streaming reply as a single
 * Mattermost post with two independent layers:
 *
 *   - body: the actual reply text from the language model
 *   - status: a short italic line beneath the body for tool-call hints
 *
 * Layering matters because tool calls can arrive mid-stream — without it,
 * onToolCall would clobber the partial body.
 */
final class MattermostStreamingReply implements StreamObserver
{
    private ?string $postId = null;

    private string $body = '';

    private string $status = '';

    public function __construct(
        private readonly Mattermost $mattermost,
        private readonly string $channelId,
        private readonly ?string $rootId = null,
    ) {}

    public function postId(): ?string
    {
        return $this->postId;
    }

    public function onFirstContent(string $text): void
    {
        $this->body = $text;
        $this->status = '';
        $this->ensurePostExists();
    }

    public function onText(string $fullText): void
    {
        $this->body = $fullText;
        $this->ensurePostExists();
    }

    public function onToolCall(string $toolName): void
    {
        $this->status = '_'.$toolName.'_';
        $this->ensurePostExists();
    }

    public function onComplete(string $finalText): void
    {
        $this->body = $finalText;
        $this->status = '';

        if ($finalText === '' && $this->postId === null) {
            return;
        }

        $this->ensurePostExists();
    }

    private function ensurePostExists(): void
    {
        if ($this->postId === null) {
            $this->createPost();

            return;
        }

        $this->updatePost();
    }

    private function compose(): string
    {
        if ($this->status === '') {
            return $this->body;
        }

        return $this->body === ''
            ? $this->status
            : $this->body."\n\n".$this->status;
    }

    private function createPost(): void
    {
        $request = new CreatePost;
        $body = [
            'channel_id' => $this->channelId,
            'message' => $this->compose(),
        ];

        if ($this->rootId !== null) {
            $body['root_id'] = $this->rootId;
        }

        $request->body()->merge($body);

        $response = $this->mattermost->send($request);
        $id = $response->json('id');

        if (is_string($id)) {
            $this->postId = $id;
        }
    }

    private function updatePost(): void
    {
        if ($this->postId === null) {
            return;
        }

        $request = new UpdatePost($this->postId);
        $request->body()->merge([
            'id' => $this->postId,
            'message' => $this->compose(),
        ]);

        $this->mattermost->send($request);
    }
}
