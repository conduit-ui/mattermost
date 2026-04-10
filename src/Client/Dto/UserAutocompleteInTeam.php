<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserAutocompleteInTeam extends SpatieData
{
	public function __construct(
		#[MapName('in_team')]
		public ?array $inTeam = null,
	) {
	}
}
