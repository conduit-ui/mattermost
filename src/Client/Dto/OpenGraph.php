<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * OpenGraph metadata of a webpage
 */
class OpenGraph extends SpatieData
{
    /**
     * @param  array<int, mixed>  $audios
     * @param  array<int, mixed>  $images
     */
    public function __construct(
        public ?object $article = null,
        public ?array $audios = null,
        public ?object $book = null,
        public ?string $description = null,
        public ?string $determiner = null,
        public ?array $images = null,
        public ?string $locale = null,
        #[MapName('locales_alternate')]
        public ?array $localesAlternate = null,
        public ?object $profile = null,
        #[MapName('site_name')]
        public ?string $siteName = null,
        public ?string $title = null,
        public ?string $type = null,
        public ?string $url = null,
        public ?array $videos = null,
    ) {}
}
