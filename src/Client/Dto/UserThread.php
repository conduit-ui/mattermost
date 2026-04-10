<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * a thread that user is following
 */
class UserThread extends SpatieData
{
	public function __construct(
		public ?string $id = null,
		#[MapName('last_reply_at')]
		public ?int $lastReplyAt = null,
		#[MapName('last_viewed_at')]
		public ?int $lastViewedAt = null,
		public ?array $participants = null,
		public ?Post $post = null,
		#[MapName('reply_count')]
		public ?int $replyCount = null,
	) {
	}
}
