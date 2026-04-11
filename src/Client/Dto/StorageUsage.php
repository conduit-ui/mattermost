<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class StorageUsage extends SpatieData
{
    public function __construct(
        public int|float|null $bytes = null,
    ) {}
}
