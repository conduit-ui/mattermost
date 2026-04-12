<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Preference extends SpatieData
{
    public function __construct(
        public ?string $category = null,
        public ?string $name = null,
        #[MapName('user_id')]
        public ?string $userId = null,
        public ?string $value = null,
    ) {}
}
