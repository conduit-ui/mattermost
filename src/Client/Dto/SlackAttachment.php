<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SlackAttachment extends SpatieData
{
    public function __construct(
        #[MapName('AuthorIcon')]
        public ?string $authorIcon = null,
        #[MapName('AuthorLink')]
        public ?string $authorLink = null,
        #[MapName('AuthorName')]
        public ?string $authorName = null,
        #[MapName('Color')]
        public ?string $color = null,
        #[MapName('Fallback')]
        public ?string $fallback = null,
        #[MapName('Fields')]
        public ?array $fields = null,
        #[MapName('Footer')]
        public ?string $footer = null,
        #[MapName('FooterIcon')]
        public ?string $footerIcon = null,
        #[MapName('Id')]
        public ?string $id = null,
        #[MapName('ImageURL')]
        public ?string $imageUrl = null,
        #[MapName('Pretext')]
        public ?string $pretext = null,
        #[MapName('Text')]
        public ?string $text = null,
        #[MapName('ThumbURL')]
        public ?string $thumbUrl = null,
        #[MapName('Timestamp')]
        public ?string $timestamp = null,
        #[MapName('Title')]
        public ?string $title = null,
        #[MapName('TitleLink')]
        public ?string $titleLink = null,
    ) {}
}
