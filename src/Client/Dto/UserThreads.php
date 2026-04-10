<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class UserThreads extends SpatieData
{
	public function __construct(
		public ?array $threads = null,
		public ?int $total = null,
	) {
	}
}
