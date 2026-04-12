<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ServerBusy extends SpatieData
{
    public function __construct(
        public ?bool $busy = null,
        public ?int $expires = null,
    ) {}
}
