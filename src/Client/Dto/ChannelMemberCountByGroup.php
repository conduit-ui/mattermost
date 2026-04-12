<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * An object describing group member information in a channel
 */
class ChannelMemberCountByGroup extends SpatieData
{
    public function __construct(
        #[MapName('channel_member_count')]
        public int|float|null $channelMemberCount = null,
        #[MapName('channel_member_timezones_count')]
        public int|float|null $channelMemberTimezonesCount = null,
        #[MapName('group_id')]
        public ?string $groupId = null,
    ) {}
}
