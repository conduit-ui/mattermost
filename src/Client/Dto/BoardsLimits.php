<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class BoardsLimits extends SpatieData
{
	public function __construct(
		public ?int $cards = null,
		public ?int $views = null,
	) {
	}
}
