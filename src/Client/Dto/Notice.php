<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class Notice extends SpatieData
{
	public function __construct(
		public ?string $action = null,
		public ?string $actionParam = null,
		public ?string $actionText = null,
		public ?string $description = null,
		public ?string $id = null,
		public ?string $image = null,
		public ?bool $sysAdminOnly = null,
		public ?bool $teamAdminOnly = null,
		public ?string $title = null,
	) {
	}
}
