<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class GlobalDataRetentionPolicy extends SpatieData
{
    public function __construct(
        #[MapName('file_deletion_enabled')]
        public ?bool $fileDeletionEnabled = null,
        #[MapName('file_retention_cutoff')]
        public ?int $fileRetentionCutoff = null,
        #[MapName('message_deletion_enabled')]
        public ?bool $messageDeletionEnabled = null,
        #[MapName('message_retention_cutoff')]
        public ?int $messageRetentionCutoff = null,
    ) {}
}
