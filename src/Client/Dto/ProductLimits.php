<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

class ProductLimits extends SpatieData
{
    public function __construct(
        public ?BoardsLimits $boards = null,
        public ?FilesLimits $files = null,
        public ?IntegrationsLimits $integrations = null,
        public ?MessagesLimits $messages = null,
        public ?TeamsLimits $teams = null,
    ) {}
}
