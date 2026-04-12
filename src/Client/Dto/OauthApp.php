<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class OauthApp extends SpatieData
{
    public function __construct(
        #[MapName('callback_urls')]
        public ?array $callbackUrls = null,
        #[MapName('client_secret')]
        public ?string $clientSecret = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        public ?string $description = null,
        public ?string $homepage = null,
        #[MapName('icon_url')]
        public ?string $iconUrl = null,
        public ?string $id = null,
        #[MapName('is_trusted')]
        public ?bool $isTrusted = null,
        public ?string $name = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
    ) {}
}
