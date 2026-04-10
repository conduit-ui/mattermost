<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ChannelNotifyProps extends SpatieData
{
	public function __construct(
		public ?string $desktop = null,
		public ?string $email = null,
		#[MapName('mark_unread')]
		public ?string $markUnread = null,
		public ?string $push = null,
	) {
	}
}
