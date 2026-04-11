<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * an object containing the results of a relational integrity check.
 */
class RelationalIntegrityCheckData extends SpatieData
{
    public function __construct(
        #[MapName('child_id_attr')]
        public ?string $childIdAttr = null,
        #[MapName('child_name')]
        public ?string $childName = null,
        #[MapName('parent_id_attr')]
        public ?string $parentIdAttr = null,
        #[MapName('parent_name')]
        public ?string $parentName = null,
        public ?array $records = null,
    ) {}
}
