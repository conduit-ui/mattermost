<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * User's sidebar category with it's channels
 */
class SidebarCategoryWithChannels extends SpatieData
{
	public function __construct(
		#[MapName('channel_ids')]
		public ?array $channelIds = null,
		#[MapName('display_name')]
		public ?string $displayName = null,
		public ?string $id = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
		public ?string $type = null,
		#[MapName('user_id')]
		public ?string $userId = null,
	) {
	}
}
