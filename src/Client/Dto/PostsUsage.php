<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PostsUsage extends SpatieData
{
	public function __construct(
		public int|float|null $count = null,
	) {
	}
}
