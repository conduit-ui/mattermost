<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class FileInfo extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        public ?string $extension = null,
        #[MapName('has_preview_image')]
        public ?bool $hasPreviewImage = null,
        public ?int $height = null,
        public ?string $id = null,
        #[MapName('mime_type')]
        public ?string $mimeType = null,
        public ?string $name = null,
        #[MapName('post_id')]
        public ?string $postId = null,
        public ?int $size = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
        #[MapName('user_id')]
        public ?string $userId = null,
        public ?int $width = null,
    ) {}
}
