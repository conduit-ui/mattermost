<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ClusterInfo extends SpatieData
{
	public function __construct(
		#[MapName('config_hash')]
		public ?string $configHash = null,
		public ?string $hostname = null,
		public ?string $id = null,
		#[MapName('internode_url')]
		public ?string $internodeUrl = null,
		#[MapName('is_alive')]
		public ?bool $isAlive = null,
		#[MapName('last_ping')]
		public ?int $lastPing = null,
		public ?string $version = null,
	) {
	}
}
