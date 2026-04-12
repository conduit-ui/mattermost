<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TopThread extends SpatieData
{
    public function __construct(
        #[MapName('Participants')]
        public ?array $participants = null,
        #[MapName('channel_display_name')]
        public ?string $channelDisplayName = null,
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('channel_name')]
        public ?string $channelName = null,
        public ?Post $post = null,
        #[MapName('user_information')]
        public ?InsightUserInformation $userInformation = null,
    ) {}
}
