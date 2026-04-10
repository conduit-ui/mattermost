<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PlaybookRunList extends SpatieData
{
	public function __construct(
		#[MapName('has_more')]
		public ?bool $hasMore = null,
		public ?array $items = null,
		#[MapName('page_count')]
		public ?int $pageCount = null,
		#[MapName('total_count')]
		public ?int $totalCount = null,
	) {
	}
}
