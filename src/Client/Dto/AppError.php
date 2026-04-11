<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AppError extends SpatieData
{
    public function __construct(
        public ?string $id = null,
        public ?string $message = null,
        #[MapName('request_id')]
        public ?string $requestId = null,
        #[MapName('status_code')]
        public ?int $statusCode = null,
    ) {}
}
