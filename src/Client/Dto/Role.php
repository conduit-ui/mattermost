<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Role extends SpatieData
{
    public function __construct(
        public ?string $description = null,
        #[MapName('display_name')]
        public ?string $displayName = null,
        public ?string $id = null,
        public ?string $name = null,
        public ?array $permissions = null,
        #[MapName('scheme_managed')]
        public ?bool $schemeManaged = null,
    ) {}
}
