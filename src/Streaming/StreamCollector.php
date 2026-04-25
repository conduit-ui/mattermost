<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Streaming;

use ConduitUI\Mattermost\Streaming\Chunks\StreamChunk;
use ConduitUI\Mattermost\Streaming\Chunks\TextChunk;
use ConduitUI\Mattermost\Streaming\Chunks\ToolCallChunk;

final readonly class StreamCollector
{
    public function __construct(
        private float $updateInterval = 1.5,
        private int $minCharDelta = 20,
    ) {}

    /**
     * @param  iterable<StreamChunk>  $stream
     */
    public function collect(iterable $stream, StreamObserver $observer): string
    {
        $text = '';
        $firstContentEmitted = false;
        $lastUpdateAt = microtime(true);
        $lastUpdateLen = 0;

        foreach ($stream as $chunk) {
            if ($chunk instanceof TextChunk) {
                $text .= $chunk->text;

                if (! $firstContentEmitted && strlen($text) >= $this->minCharDelta) {
                    $observer->onFirstContent($text);
                    $firstContentEmitted = true;
                    $lastUpdateAt = microtime(true);
                    $lastUpdateLen = strlen($text);

                    continue;
                }

                $now = microtime(true);
                if ($firstContentEmitted
                    && ($now - $lastUpdateAt) >= $this->updateInterval
                    && (strlen($text) - $lastUpdateLen) >= $this->minCharDelta
                ) {
                    $observer->onText($text);
                    $lastUpdateAt = $now;
                    $lastUpdateLen = strlen($text);
                }
            } elseif ($chunk instanceof ToolCallChunk) {
                $observer->onToolCall($chunk->name);
            }
        }

        if (! $firstContentEmitted && $text !== '') {
            $observer->onFirstContent($text);
        }

        $observer->onComplete($text);

        return trim($text);
    }
}
