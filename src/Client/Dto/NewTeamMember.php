<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class NewTeamMember extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('first_name')]
        public ?string $firstName = null,
        public ?string $id = null,
        #[MapName('last_name')]
        public ?string $lastName = null,
        public ?string $nickname = null,
        public ?string $position = null,
        public ?string $username = null,
    ) {}
}
