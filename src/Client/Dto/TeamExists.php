<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class TeamExists extends SpatieData
{
	public function __construct(
		public ?bool $exists = null,
	) {
	}
}
