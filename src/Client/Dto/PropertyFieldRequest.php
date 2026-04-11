<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PropertyFieldRequest extends SpatieData
{
    public function __construct(
        public ?object $attrs = null,
        public ?string $name = null,
        public ?string $type = null,
    ) {}
}
