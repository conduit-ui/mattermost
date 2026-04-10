<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserAccessToken extends SpatieData
{
	public function __construct(
		public ?string $description = null,
		public ?string $id = null,
		public ?string $token = null,
		#[MapName('user_id')]
		public ?string $userId = null,
	) {
	}
}
