<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class UserThreads extends SpatieData
{
    /**
     * @param  array<int, mixed>  $threads
     */
    public function __construct(
        public ?array $threads = null,
        public ?int $total = null,
    ) {}
}
