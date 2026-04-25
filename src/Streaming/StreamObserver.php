<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Streaming;

interface StreamObserver
{
    public function onFirstContent(string $text): void;

    public function onText(string $fullText): void;

    public function onToolCall(string $toolName): void;

    public function onComplete(string $finalText): void;
}
