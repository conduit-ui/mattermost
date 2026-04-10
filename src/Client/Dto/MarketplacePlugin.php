<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class MarketplacePlugin extends SpatieData
{
	public function __construct(
		#[MapName('download_url')]
		public ?string $downloadUrl = null,
		#[MapName('homepage_url')]
		public ?string $homepageUrl = null,
		#[MapName('icon_data')]
		public ?string $iconData = null,
		#[MapName('installed_version')]
		public ?string $installedVersion = null,
		public ?array $labels = null,
		public ?PluginManifest $manifest = null,
		#[MapName('release_notes_url')]
		public ?string $releaseNotesUrl = null,
		public ?string $signature = null,
	) {
	}
}
