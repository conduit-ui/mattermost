<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SlackAttachmentField extends SpatieData
{
    public function __construct(
        #[MapName('Short')]
        public ?bool $short = null,
        #[MapName('Title')]
        public ?string $title = null,
        #[MapName('Value')]
        public ?string $value = null,
    ) {}
}
