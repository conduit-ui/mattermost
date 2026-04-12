<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TeamMember extends SpatieData
{
    public function __construct(
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        #[MapName('explicit_roles')]
        public ?string $explicitRoles = null,
        public ?string $roles = null,
        #[MapName('scheme_admin')]
        public ?bool $schemeAdmin = null,
        #[MapName('scheme_user')]
        public ?bool $schemeUser = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
