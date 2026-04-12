<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Subscription extends SpatieData
{
    public function __construct(
        #[MapName('add_ons')]
        public ?array $addOns = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('customer_id')]
        public ?string $customerId = null,
        public ?string $dns = null,
        #[MapName('end_at')]
        public ?int $endAt = null,
        public ?string $id = null,
        #[MapName('product_id')]
        public ?string $productId = null,
        public ?int $seats = null,
        #[MapName('start_at')]
        public ?int $startAt = null,
    ) {}
}
