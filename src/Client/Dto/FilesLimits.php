<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class FilesLimits extends SpatieData
{
    public function __construct(
        #[MapName('total_storage')]
        public ?int $totalStorage = null,
    ) {}
}
