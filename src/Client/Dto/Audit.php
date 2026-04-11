<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Audit extends SpatieData
{
    public function __construct(
        public ?string $action = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('extra_info')]
        public ?string $extraInfo = null,
        public ?string $id = null,
        #[MapName('ip_address')]
        public ?string $ipAddress = null,
        #[MapName('session_id')]
        public ?string $sessionId = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
