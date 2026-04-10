<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PluginManifestWebapp extends SpatieData
{
	public function __construct(
		public ?string $id = null,
		public ?string $version = null,
		public ?object $webapp = null,
	) {
	}
}
