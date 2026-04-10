<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ChannelModeratedRole extends SpatieData
{
	public function __construct(
		public ?bool $enabled = null,
		public ?bool $value = null,
	) {
	}
}
