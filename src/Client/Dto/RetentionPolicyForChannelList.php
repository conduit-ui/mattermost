<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class RetentionPolicyForChannelList extends SpatieData
{
    /**
     * @param  array<int, mixed>  $policies
     */
    public function __construct(
        public ?array $policies = null,
        #[MapName('total_count')]
        public ?int $totalCount = null,
    ) {}
}
