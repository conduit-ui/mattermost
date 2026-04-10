<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TeamUnread extends SpatieData
{
	public function __construct(
		#[MapName('mention_count')]
		public ?int $mentionCount = null,
		#[MapName('msg_count')]
		public ?int $msgCount = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
	) {
	}
}
