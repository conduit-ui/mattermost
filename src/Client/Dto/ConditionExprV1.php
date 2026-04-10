<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * A logical condition expression that can combine multiple conditions using AND/OR operators, or
 * perform field comparisons using Is/IsNot operators.
 */
class ConditionExprV1 extends SpatieData
{
	public function __construct(
		public ?array $and = null,
		public ?ComparisonCondition $is = null,
		public ?ComparisonCondition $isNot = null,
		public ?array $or = null,
	) {
	}
}
