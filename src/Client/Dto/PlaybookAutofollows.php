<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PlaybookAutofollows extends SpatieData
{
	public function __construct(
		public ?array $items = null,
		#[MapName('total_count')]
		public ?int $totalCount = null,
	) {
	}
}
