<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Streaming\Chunks;

final readonly class TextChunk implements StreamChunk
{
    public function __construct(public string $text) {}
}
