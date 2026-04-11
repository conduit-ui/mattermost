<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PostAcknowledgement extends SpatieData
{
    public function __construct(
        #[MapName('acknowledged_at')]
        public ?int $acknowledgedAt = null,
        #[MapName('post_id')]
        public ?string $postId = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
