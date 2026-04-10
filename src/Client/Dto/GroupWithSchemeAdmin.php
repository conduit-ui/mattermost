<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * group augmented with scheme admin information
 */
class GroupWithSchemeAdmin extends SpatieData
{
	public function __construct(
		public ?Group $group = null,
		#[MapName('scheme_admin')]
		public ?bool $schemeAdmin = null,
	) {
	}
}
