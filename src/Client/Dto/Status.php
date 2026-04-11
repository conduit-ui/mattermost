<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Status extends SpatieData
{
    public function __construct(
        #[MapName('last_activity_at')]
        public ?int $lastActivityAt = null,
        public ?bool $manual = null,
        public ?string $status = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
