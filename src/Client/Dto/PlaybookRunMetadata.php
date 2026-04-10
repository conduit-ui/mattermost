<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PlaybookRunMetadata extends SpatieData
{
	public function __construct(
		#[MapName('channel_display_name')]
		public ?string $channelDisplayName = null,
		#[MapName('channel_name')]
		public ?string $channelName = null,
		#[MapName('num_members')]
		public ?int $numMembers = null,
		#[MapName('team_name')]
		public ?string $teamName = null,
		#[MapName('total_posts')]
		public ?int $totalPosts = null,
	) {
	}
}
