<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TopReaction extends SpatieData
{
	public function __construct(
		public ?int $count = null,
		#[MapName('emoji_name')]
		public ?string $emojiName = null,
	) {
	}
}
