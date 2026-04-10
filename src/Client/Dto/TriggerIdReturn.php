<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TriggerIdReturn extends SpatieData
{
	public function __construct(
		#[MapName('trigger_id')]
		public ?string $triggerId = null,
	) {
	}
}
