<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class DataRetentionPolicyForChannel extends SpatieData
{
	public function __construct(
		#[MapName('channel_id')]
		public ?string $channelId = null,
		#[MapName('post_duration')]
		public ?int $postDuration = null,
	) {
	}
}
