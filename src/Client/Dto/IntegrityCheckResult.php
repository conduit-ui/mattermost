<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * an object with the result of the integrity check.
 */
class IntegrityCheckResult extends SpatieData
{
	public function __construct(
		public ?RelationalIntegrityCheckData $data = null,
		public ?string $err = null,
	) {
	}
}
