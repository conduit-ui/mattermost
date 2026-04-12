<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AddOn extends SpatieData
{
    public function __construct(
        #[MapName('display_name')]
        public ?string $displayName = null,
        public ?string $id = null,
        public ?string $name = null,
        #[MapName('price_per_seat')]
        public ?string $pricePerSeat = null,
    ) {}
}
