<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PaymentMethod extends SpatieData
{
    public function __construct(
        #[MapName('card_brand')]
        public ?string $cardBrand = null,
        #[MapName('exp_month')]
        public ?int $expMonth = null,
        #[MapName('exp_year')]
        public ?int $expYear = null,
        #[MapName('last_four')]
        public ?int $lastFour = null,
        public ?string $name = null,
        public ?string $type = null,
    ) {}
}
