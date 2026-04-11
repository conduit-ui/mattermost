<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Reaction extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('emoji_name')]
        public ?string $emojiName = null,
        #[MapName('post_id')]
        public ?string $postId = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
