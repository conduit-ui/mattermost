<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserAutocompleteInChannel extends SpatieData
{
	public function __construct(
		#[MapName('in_channel')]
		public ?array $inChannel = null,
		#[MapName('out_of_channel')]
		public ?array $outOfChannel = null,
	) {
	}
}
