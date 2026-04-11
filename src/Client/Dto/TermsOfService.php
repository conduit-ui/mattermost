<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TermsOfService extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        public ?string $id = null,
        public ?string $text = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
