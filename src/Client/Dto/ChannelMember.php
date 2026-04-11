<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ChannelMember extends SpatieData
{
    public function __construct(
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('last_update_at')]
        public ?int $lastUpdateAt = null,
        #[MapName('last_viewed_at')]
        public ?int $lastViewedAt = null,
        #[MapName('mention_count')]
        public ?int $mentionCount = null,
        #[MapName('msg_count')]
        public ?int $msgCount = null,
        #[MapName('notify_props')]
        public ?ChannelNotifyProps $notifyProps = null,
        public ?string $roles = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
