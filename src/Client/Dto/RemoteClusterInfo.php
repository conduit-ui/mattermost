<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class RemoteClusterInfo extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('display_name')]
        public ?string $displayName = null,
        #[MapName('last_ping_at')]
        public ?int $lastPingAt = null,
    ) {}
}
