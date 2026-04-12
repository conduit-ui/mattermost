<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SubscriptionStats extends SpatieData
{
    public function __construct(
        #[MapName('is_paid_tier')]
        public ?string $isPaidTier = null,
        #[MapName('remaining_seats')]
        public ?int $remainingSeats = null,
    ) {}
}
