<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Streaming\Chunks\TextChunk;
use ConduitUI\Mattermost\Streaming\Chunks\ToolCallChunk;
use ConduitUI\Mattermost\Streaming\StreamCollector;
use ConduitUI\Mattermost\Streaming\StreamObserver;

function recordingObserver(): StreamObserver
{
    return new class implements StreamObserver
    {
        /** @var list<array{0: string, 1: string}> */
        public array $calls = [];

        public function onFirstContent(string $text): void
        {
            $this->calls[] = ['onFirstContent', $text];
        }

        public function onText(string $fullText): void
        {
            $this->calls[] = ['onText', $fullText];
        }

        public function onToolCall(string $toolName): void
        {
            $this->calls[] = ['onToolCall', $toolName];
        }

        public function onComplete(string $finalText): void
        {
            $this->calls[] = ['onComplete', $finalText];
        }
    };
}

describe('StreamCollector', function (): void {
    it('emits onFirstContent once char threshold is met', function (): void {
        $observer = recordingObserver();
        $stream = [
            new TextChunk('Hello '),
            new TextChunk('world, this is a '),
            new TextChunk('long enough chunk'),
        ];

        $collector = new StreamCollector(updateInterval: 1.5, minCharDelta: 20);
        $result = $collector->collect($stream, $observer);

        expect($result)->toBe('Hello world, this is a long enough chunk');
        expect($observer->calls[0][0])->toBe('onFirstContent');
        expect($observer->calls[0][1])->toContain('Hello world, this is a');
    });

    it('always emits onComplete with the full text', function (): void {
        $observer = recordingObserver();

        (new StreamCollector)->collect([
            new TextChunk('chunk one '),
            new TextChunk('chunk two'),
        ], $observer);

        $last = end($observer->calls);
        expect($last[0])->toBe('onComplete');
        expect($last[1])->toBe('chunk one chunk two');
    });

    it('emits onFirstContent even for short replies under the threshold', function (): void {
        $observer = recordingObserver();

        (new StreamCollector(minCharDelta: 100))->collect([
            new TextChunk('hi'),
        ], $observer);

        expect($observer->calls[0][0])->toBe('onFirstContent');
        expect($observer->calls[0][1])->toBe('hi');
        expect(end($observer->calls)[0])->toBe('onComplete');
    });

    it('does not emit onFirstContent when stream is empty', function (): void {
        $observer = recordingObserver();

        (new StreamCollector)->collect([], $observer);

        expect($observer->calls)->toHaveCount(1);
        expect($observer->calls[0])->toBe(['onComplete', '']);
    });

    it('forwards tool calls to the observer in order', function (): void {
        $observer = recordingObserver();

        (new StreamCollector)->collect([
            new TextChunk('searching for the '),
            new TextChunk('answer to your question'),
            new ToolCallChunk('MemorySearch'),
            new ToolCallChunk('WebSearch'),
        ], $observer);

        $toolCalls = array_values(array_filter($observer->calls, fn ($c) => $c[0] === 'onToolCall'));
        expect($toolCalls)->toBe([
            ['onToolCall', 'MemorySearch'],
            ['onToolCall', 'WebSearch'],
        ]);
    });

    it('throttles onText updates by both interval and char delta', function (): void {
        $observer = recordingObserver();
        // Two chunks far above char threshold but inside the interval window.
        // Only the first triggers onFirstContent; the second should NOT trigger
        // onText because the interval (1.5s) hasn't elapsed.
        (new StreamCollector(updateInterval: 1.5, minCharDelta: 20))->collect([
            new TextChunk(str_repeat('a', 25)),
            new TextChunk(str_repeat('b', 25)),
        ], $observer);

        $onTextCalls = array_filter($observer->calls, fn ($c) => $c[0] === 'onText');
        expect($onTextCalls)->toBeEmpty();
    });

    it('returns the trimmed final text', function (): void {
        $observer = recordingObserver();

        $result = (new StreamCollector)->collect([
            new TextChunk("  hello world  \n"),
        ], $observer);

        expect($result)->toBe('hello world');
    });
});
