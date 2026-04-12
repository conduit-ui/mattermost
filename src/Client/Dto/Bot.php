<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * A bot account
 */
class Bot extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        public ?string $description = null,
        #[MapName('display_name')]
        public ?string $displayName = null,
        #[MapName('owner_id')]
        public ?string $ownerId = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
        #[MapName('user_id')]
        public ?string $userId = null,
        public ?string $username = null,
    ) {}
}
