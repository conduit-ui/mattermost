<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Emoji extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('creator_id')]
        public ?string $creatorId = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        public ?string $id = null,
        public ?string $name = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
    ) {}
}
