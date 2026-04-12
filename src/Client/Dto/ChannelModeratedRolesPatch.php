<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ChannelModeratedRolesPatch extends SpatieData
{
    public function __construct(
        public ?bool $guests = null,
        public ?bool $members = null,
    ) {}
}
