<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Address extends SpatieData
{
	public function __construct(
		public ?string $city = null,
		public ?string $country = null,
		public ?string $line1 = null,
		public ?string $line2 = null,
		#[MapName('postal_code')]
		public ?string $postalCode = null,
		public ?string $state = null,
	) {
	}
}
