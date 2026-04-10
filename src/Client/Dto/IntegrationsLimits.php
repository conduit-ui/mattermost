<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class IntegrationsLimits extends SpatieData
{
	public function __construct(
		public ?int $enabled = null,
	) {
	}
}
