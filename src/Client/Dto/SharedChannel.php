<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SharedChannel extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('creator_id')]
        public ?string $creatorId = null,
        #[MapName('display_name')]
        public ?string $displayName = null,
        public ?string $header = null,
        public ?bool $home = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?string $purpose = null,
        public ?bool $readonly = null,
        #[MapName('remote_id')]
        public ?string $remoteId = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
    ) {}
}
