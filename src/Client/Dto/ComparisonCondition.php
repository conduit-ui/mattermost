<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ComparisonCondition extends SpatieData
{
	public function __construct(
		#[MapName('field_id')]
		public ?string $fieldId = null,
		public mixed $value = null,
	) {
	}
}
