<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class GroupSyncableChannels extends SpatieData
{
    public function __construct(
        #[MapName('auto_add')]
        public ?bool $autoAdd = null,
        #[MapName('channel_display_name')]
        public ?string $channelDisplayName = null,
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('channel_type')]
        public ?string $channelType = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        #[MapName('group_id')]
        public ?string $groupId = null,
        #[MapName('team_display_name')]
        public ?string $teamDisplayName = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        #[MapName('team_type')]
        public ?string $teamType = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
    ) {}
}
