<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Playbook extends SpatieData
{
    /**
     * @param  array<int, mixed>  $checklists
     */
    public function __construct(
        public ?array $checklists = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('create_public_playbook_run')]
        public ?bool $createPublicPlaybookRun = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        public ?string $description = null,
        public ?string $id = null,
        #[MapName('member_ids')]
        public ?array $memberIds = null,
        #[MapName('num_stages')]
        public ?int $numStages = null,
        #[MapName('num_steps')]
        public ?int $numSteps = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        public ?string $title = null,
    ) {}
}
