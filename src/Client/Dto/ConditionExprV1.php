<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * A logical condition expression that can combine multiple conditions using AND/OR operators, or
 * perform field comparisons using Is/IsNot operators.
 */
class ConditionExprV1 extends SpatieData
{
    /**
     * @param  array<int, mixed>  $and
     * @param  array<int, mixed>  $or
     */
    public function __construct(
        public ?array $and = null,
        public ?ComparisonCondition $is = null,
        public ?ComparisonCondition $isNot = null,
        public ?array $or = null,
    ) {}
}
