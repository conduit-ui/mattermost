<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class AutocompleteSuggestion extends SpatieData
{
    public function __construct(
        #[MapName('Complete')]
        public ?string $complete = null,
        #[MapName('Description')]
        public ?string $description = null,
        #[MapName('Hint')]
        public ?string $hint = null,
        #[MapName('IconData')]
        public ?string $iconData = null,
        #[MapName('Suggestion')]
        public ?string $suggestion = null,
    ) {}
}
