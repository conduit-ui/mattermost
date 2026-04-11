<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * an object containing information used to keep track of a file upload.
 */
class UploadSession extends SpatieData
{
    public function __construct(
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('file_offset')]
        public ?int $fileOffset = null,
        #[MapName('file_size')]
        public ?int $fileSize = null,
        public ?string $filename = null,
        public ?string $id = null,
        public ?string $type = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
