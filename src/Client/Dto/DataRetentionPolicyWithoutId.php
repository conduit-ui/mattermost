<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class DataRetentionPolicyWithoutId extends SpatieData
{
    public function __construct(
        #[MapName('display_name')]
        public ?string $displayName = null,
        #[MapName('post_duration')]
        public ?int $postDuration = null,
    ) {}
}
