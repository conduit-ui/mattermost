<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserTermsOfService extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('terms_of_service_id')]
        public ?string $termsOfServiceId = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
