<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ChannelData extends SpatieData
{
    public function __construct(
        public ?Channel $channel = null,
        public ?ChannelMember $member = null,
    ) {}
}
