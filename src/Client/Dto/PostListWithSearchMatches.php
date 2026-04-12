<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class PostListWithSearchMatches extends SpatieData
{
    /**
     * @param  array<int, mixed>  $order
     */
    public function __construct(
        public ?object $matches = null,
        public ?array $order = null,
        public ?object $posts = null,
    ) {}
}
