<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AnalyticsSettings extends SpatieData
{
	public function __construct(
		#[MapName('MaxUsersForStatistics')]
		public ?int $maxUsersForStatistics = null,
	) {
	}
}
