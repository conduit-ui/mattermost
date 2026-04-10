<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class DataRetentionPolicyForTeam extends SpatieData
{
	public function __construct(
		#[MapName('post_duration')]
		public ?int $postDuration = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
	) {
	}
}
