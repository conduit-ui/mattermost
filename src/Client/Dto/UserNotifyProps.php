<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class UserNotifyProps extends SpatieData
{
    public function __construct(
        public ?string $channel = null,
        public ?string $desktop = null,
        #[MapName('desktop_sound')]
        public ?string $desktopSound = null,
        public ?string $email = null,
        #[MapName('first_name')]
        public ?string $firstName = null,
        #[MapName('mention_keys')]
        public ?string $mentionKeys = null,
        public ?string $push = null,
    ) {}
}
