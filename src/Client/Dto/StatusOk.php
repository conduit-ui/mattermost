<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class StatusOk extends SpatieData
{
	public function __construct(
		public ?string $status = null,
	) {
	}
}
