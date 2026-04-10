<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * List of user's categories with their channels
 */
class OrderedSidebarCategories extends SpatieData
{
	public function __construct(
		public ?array $categories = null,
		public ?array $order = null,
	) {
	}
}
