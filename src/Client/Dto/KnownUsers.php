<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class KnownUsers extends SpatieData
{
	public function __construct(
		public ?string $items = null,
	) {
	}
}
