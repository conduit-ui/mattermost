<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PaymentSetupIntent extends SpatieData
{
	public function __construct(
		#[MapName('client_secret')]
		public ?string $clientSecret = null,
		public ?string $id = null,
	) {
	}
}
