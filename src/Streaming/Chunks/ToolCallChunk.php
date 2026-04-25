<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Streaming\Chunks;

final readonly class ToolCallChunk implements StreamChunk
{
    public function __construct(public string $name) {}
}
