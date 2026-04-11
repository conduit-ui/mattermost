<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PluginManifest extends SpatieData
{
    public function __construct(
        public ?object $backend = null,
        public ?string $description = null,
        public ?string $id = null,
        #[MapName('min_server_version')]
        public ?string $minServerVersion = null,
        public ?string $name = null,
        public ?object $server = null,
        #[MapName('settings_schema')]
        public ?object $settingsSchema = null,
        public ?string $version = null,
        public ?object $webapp = null,
    ) {}
}
