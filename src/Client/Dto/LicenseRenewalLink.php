<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class LicenseRenewalLink extends SpatieData
{
    public function __construct(
        #[MapName('renewal_link')]
        public ?string $renewalLink = null,
    ) {}
}
