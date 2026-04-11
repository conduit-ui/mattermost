<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TopChannel extends SpatieData
{
    public function __construct(
        #[MapName('display_name')]
        public ?string $displayName = null,
        public ?string $id = null,
        #[MapName('message_count')]
        public ?string $messageCount = null,
        public ?string $name = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        public ?string $type = null,
    ) {}
}
