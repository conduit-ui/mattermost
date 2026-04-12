<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PlaybookAutofollows extends SpatieData
{
    /**
     * @param  array<int, mixed>  $items
     */
    public function __construct(
        public ?array $items = null,
        #[MapName('total_count')]
        public ?int $totalCount = null,
    ) {}
}
