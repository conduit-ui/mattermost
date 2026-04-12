<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserAccessTokenSanitized extends SpatieData
{
    public function __construct(
        public ?string $description = null,
        public ?string $id = null,
        #[MapName('is_active')]
        public ?bool $isActive = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
