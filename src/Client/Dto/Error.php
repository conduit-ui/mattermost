<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class Error extends SpatieData
{
    public function __construct(
        public ?string $details = null,
        public ?string $error = null,
    ) {}
}
