<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Product extends SpatieData
{
    public function __construct(
        #[MapName('add_ons')]
        public ?array $addOns = null,
        public ?string $description = null,
        public ?string $id = null,
        public ?string $name = null,
        #[MapName('price_per_seat')]
        public ?string $pricePerSeat = null,
    ) {}
}
