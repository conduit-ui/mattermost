<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class OwnerInfo extends SpatieData
{
	public function __construct(
		#[MapName('user_id')]
		public ?string $userId = null,
		public ?string $username = null,
	) {
	}
}
