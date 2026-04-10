<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class RetentionPolicyForChannelList extends SpatieData
{
	public function __construct(
		public ?array $policies = null,
		#[MapName('total_count')]
		public ?int $totalCount = null,
	) {
	}
}
