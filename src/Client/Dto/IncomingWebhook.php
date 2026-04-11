<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class IncomingWebhook extends SpatieData
{
    public function __construct(
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        public ?string $description = null,
        #[MapName('display_name')]
        public ?string $displayName = null,
        public ?string $id = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
    ) {}
}
