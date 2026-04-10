<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ChannelModeratedRoles extends SpatieData
{
	public function __construct(
		public ?ChannelModeratedRole $guests = null,
		public ?ChannelModeratedRole $members = null,
	) {
	}
}
