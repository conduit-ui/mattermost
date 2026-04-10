<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class Timezone extends SpatieData
{
	public function __construct(
		public ?string $automaticTimezone = null,
		public ?string $manualTimezone = null,
		public ?bool $useAutomaticTimezone = null,
	) {
	}
}
