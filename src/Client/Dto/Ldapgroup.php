<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

/**
 * A LDAP group
 */
class Ldapgroup extends SpatieData
{
    public function __construct(
        #[MapName('has_syncables')]
        public ?bool $hasSyncables = null,
        #[MapName('mattermost_group_id')]
        public ?string $mattermostGroupId = null,
        public ?string $name = null,
        #[MapName('primary_key')]
        public ?string $primaryKey = null,
    ) {}
}
