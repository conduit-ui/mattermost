<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UsersStats extends SpatieData
{
    public function __construct(
        #[MapName('total_users_count')]
        public ?int $totalUsersCount = null,
    ) {}
}
