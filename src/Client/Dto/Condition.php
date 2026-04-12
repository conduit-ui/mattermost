<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Condition extends SpatieData
{
    public function __construct(
        #[MapName('condition_expr')]
        public ?ConditionExprV1 $conditionExpr = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        public ?string $id = null,
        #[MapName('playbook_id')]
        public ?string $playbookId = null,
        #[MapName('run_id')]
        public ?string $runId = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
        public ?int $version = null,
    ) {}
}
