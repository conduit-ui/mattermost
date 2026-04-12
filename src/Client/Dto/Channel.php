<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Channel extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('creator_id')]
        public ?string $creatorId = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        #[MapName('display_name')]
        public ?string $displayName = null,
        #[MapName('extra_update_at')]
        public ?int $extraUpdateAt = null,
        public ?string $header = null,
        public ?string $id = null,
        #[MapName('last_post_at')]
        public ?int $lastPostAt = null,
        public ?string $name = null,
        public ?string $purpose = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        #[MapName('total_msg_count')]
        public ?int $totalMsgCount = null,
        public ?string $type = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
    ) {}
}
