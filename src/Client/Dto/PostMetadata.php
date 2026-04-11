<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * Additional information used to display a post.
 */
class PostMetadata extends SpatieData
{
    /**
     * @param  array<int, mixed>  $acknowledgements
     * @param  array<int, mixed>  $embeds
     * @param  array<int, mixed>  $emojis
     * @param  array<int, mixed>  $files
     * @param  array<int, mixed>  $reactions
     */
    public function __construct(
        public ?array $acknowledgements = null,
        public ?array $embeds = null,
        public ?array $emojis = null,
        public ?array $files = null,
        public ?object $images = null,
        public ?object $priority = null,
        public ?array $reactions = null,
    ) {}
}
