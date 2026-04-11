<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserAuthData extends SpatieData
{
    public function __construct(
        #[MapName('auth_data')]
        public ?string $authData = null,
        #[MapName('auth_service')]
        public ?string $authService = null,
    ) {}
}
