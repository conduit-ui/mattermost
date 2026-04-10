<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ChannelModerationPatch extends SpatieData
{
	public function __construct(
		public ?string $name = null,
		public ?ChannelModeratedRolesPatch $roles = null,
	) {
	}
}
