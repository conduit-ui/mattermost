<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Unit\WebSocket\Doubles;

use Psr\Log\AbstractLogger;
use Stringable;

/**
 * PSR-3 logger that records every call so tests can assert state changes
 * and lifecycle messages without reading actual log files.
 */
final class RecordingLogger extends AbstractLogger
{
    /** @var list<array{level: mixed, message: string, context: array<string, mixed>}> */
    public array $records = [];

    #[\Override]
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $this->records[] = [
            'level' => $level,
            'message' => (string) $message,
            'context' => $context,
        ];
    }

    /**
     * @return list<string>
     */
    public function messages(): array
    {
        return array_map(static fn ($r) => $r['message'], $this->records);
    }

    public function has(string $needle): bool
    {
        foreach ($this->records as $record) {
            if (str_contains($record['message'], $needle)) {
                return true;
            }
        }

        return false;
    }
}
