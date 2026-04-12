<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Compliance extends SpatieData
{
    public function __construct(
        public ?int $count = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        public ?string $desc = null,
        public ?string $emails = null,
        #[MapName('end_at')]
        public ?int $endAt = null,
        public ?string $id = null,
        public ?string $keywords = null,
        #[MapName('start_at')]
        public ?int $startAt = null,
        public ?string $status = null,
        public ?string $type = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
