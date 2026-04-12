<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TeamStats extends SpatieData
{
    public function __construct(
        #[MapName('active_member_count')]
        public ?int $activeMemberCount = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        #[MapName('total_member_count')]
        public ?int $totalMemberCount = null,
    ) {}
}
