<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class NewTeamMembersList extends SpatieData
{
    public function __construct(
        #[MapName('has_next')]
        public ?bool $hasNext = null,
        public ?array $items = null,
        #[MapName('total_count')]
        public ?int $totalCount = null,
    ) {}
}
