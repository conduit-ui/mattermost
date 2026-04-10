<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class TeamsLimits extends SpatieData
{
	public function __construct(
		public ?int $active = null,
	) {
	}
}
