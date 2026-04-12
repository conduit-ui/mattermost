<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PropertyValue extends SpatieData
{
    public function __construct(
        #[MapName('create_at')]
        public ?int $createAt = null,
        #[MapName('delete_at')]
        public ?int $deleteAt = null,
        #[MapName('field_id')]
        public ?string $fieldId = null,
        public ?string $id = null,
        #[MapName('update_at')]
        public ?int $updateAt = null,
        public ?string $value = null,
    ) {}
}
