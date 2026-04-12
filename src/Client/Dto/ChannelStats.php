<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ChannelStats extends SpatieData
{
    public function __construct(
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('member_count')]
        public ?int $memberCount = null,
    ) {}
}
