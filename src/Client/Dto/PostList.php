<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PostList extends SpatieData
{
	public function __construct(
		#[MapName('has_next')]
		public ?bool $hasNext = null,
		#[MapName('next_post_id')]
		public ?string $nextPostId = null,
		public ?array $order = null,
		public ?object $posts = null,
		#[MapName('prev_post_id')]
		public ?string $prevPostId = null,
	) {
	}
}
