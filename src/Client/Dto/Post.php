<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Post extends SpatieData
{
    public function __construct(
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        #[MapName('edit_at')]
        public ?int $editAt = null,
        #[MapName('file_ids')]
        public ?array $fileIds = null,
        public ?string $hashtag = null,
        public ?string $id = null,
        public ?string $message = null,
        public ?PostMetadata $metadata = null,
        #[MapName('original_id')]
        public ?string $originalId = null,
        #[MapName('pending_post_id')]
        public ?string $pendingPostId = null,
        public ?object $props = null,
        #[MapName('root_id')]
        public ?string $rootId = null,
        public ?string $type = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
        #[MapName('user_id')]
        public ?string $userId = null,
    ) {}
}
