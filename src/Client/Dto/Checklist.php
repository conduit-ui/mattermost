<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class Checklist extends SpatieData
{
	public function __construct(
		public ?string $id = null,
		public ?array $items = null,
		public ?string $title = null,
	) {
	}
}
