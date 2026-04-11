<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Session extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('device_id')]
        public ?string $deviceId = null,
        #[MapName('expires_at')]
        public ?int $expiresAt = null,
        public ?string $id = null,
        #[MapName('is_oauth')]
        public ?bool $isOauth = null,
        #[MapName('last_activity_at')]
        public ?int $lastActivityAt = null,
        public ?object $props = null,
        public ?string $roles = null,
        #[MapName('team_members')]
        public ?array $teamMembers = null,
        public ?string $token = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
