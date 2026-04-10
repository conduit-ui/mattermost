<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Invoice extends SpatieData
{
	public function __construct(
		#[MapName('create_at')]
		public ?int $createAt = null,
		public ?string $id = null,
		public ?array $item = null,
		public ?string $number = null,
		#[MapName('period_end')]
		public ?int $periodEnd = null,
		#[MapName('period_start')]
		public ?int $periodStart = null,
		public ?string $status = null,
		#[MapName('subscription_id')]
		public ?string $subscriptionId = null,
		public ?int $tax = null,
		public ?int $total = null,
	) {
	}
}
