<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class MessagesLimits extends SpatieData
{
	public function __construct(
		public ?int $history = null,
	) {
	}
}
