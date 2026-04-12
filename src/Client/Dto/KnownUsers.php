<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class KnownUsers extends SpatieData
{
    public function __construct(
        public ?string $items = null,
    ) {}
}
