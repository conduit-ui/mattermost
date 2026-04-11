<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Job extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        public ?object $data = null,
        public ?string $id = null,
        #[MapName('last_activity_at')]
        public ?int $lastActivityAt = null,
        public ?int $progress = null,
        #[MapName('start_at')]
        public ?int $startAt = null,
        public ?string $status = null,
        public ?string $type = null,
    ) {}
}
