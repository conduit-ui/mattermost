<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * A mapping of teamIds to teams.
 */
class TeamMap extends SpatieData
{
	public function __construct(
		#[MapName('team_id')]
		public ?Team $teamId = null,
	) {
	}
}
