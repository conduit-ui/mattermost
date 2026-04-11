<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * an object containing information about an orphaned record.
 */
class OrphanedRecord extends SpatieData
{
    public function __construct(
        #[MapName('child_id')]
        public ?string $childId = null,
        #[MapName('parent_id')]
        public ?string $parentId = null,
    ) {}
}
