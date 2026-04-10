<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ChannelModeration extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?ChannelModeratedRoles $roles = null,
	) {
	}
}
