<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PluginStatus extends SpatieData
{
	public function __construct(
		#[MapName('cluster_id')]
		public ?string $clusterId = null,
		public ?string $description = null,
		public ?string $name = null,
		#[MapName('plugin_id')]
		public ?string $pluginId = null,
		#[MapName('plugin_path')]
		public ?string $pluginPath = null,
		public int|float|null $state = null,
		public ?string $version = null,
	) {
	}
}
