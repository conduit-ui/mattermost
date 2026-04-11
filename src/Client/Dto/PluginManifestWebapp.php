<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PluginManifestWebapp extends SpatieData
{
    public function __construct(
        public ?string $id = null,
        public ?string $version = null,
        public ?object $webapp = null,
    ) {}
}
