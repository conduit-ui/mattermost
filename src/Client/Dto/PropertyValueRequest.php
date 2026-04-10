<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PropertyValueRequest extends SpatieData
{
	public function __construct(
		public ?string $value = null,
	) {
	}
}
