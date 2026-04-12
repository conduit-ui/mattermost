<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * List of user's categories with their channels
 */
class OrderedSidebarCategories extends SpatieData
{
    /**
     * @param  array<int, mixed>  $categories
     * @param  array<int, mixed>  $order
     */
    public function __construct(
        public ?array $categories = null,
        public ?array $order = null,
    ) {}
}
