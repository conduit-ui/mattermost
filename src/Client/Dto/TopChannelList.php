<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TopChannelList extends SpatieData
{
	public function __construct(
		#[MapName('has_next')]
		public ?bool $hasNext = null,
		public ?array $items = null,
	) {
	}
}
