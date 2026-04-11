<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class InvoiceLineItem extends SpatieData
{
    /**
     * @param  array<int, mixed>  $metadata
     */
    public function __construct(
        public ?string $description = null,
        public ?array $metadata = null,
        #[MapName('price_id')]
        public ?string $priceId = null,
        #[MapName('price_per_unit')]
        public ?int $pricePerUnit = null,
        public ?int $quantity = null,
        public ?int $total = null,
    ) {}
}
