<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class System extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?string $value = null,
	) {
	}
}
