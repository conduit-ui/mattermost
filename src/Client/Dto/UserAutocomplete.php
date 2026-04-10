<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserAutocomplete extends SpatieData
{
	public function __construct(
		#[MapName('out_of_channel')]
		public ?array $outOfChannel = null,
		public ?array $users = null,
	) {
	}
}
