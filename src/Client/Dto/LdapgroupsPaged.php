<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * A paged list of LDAP groups
 */
class LdapgroupsPaged extends SpatieData
{
    /**
     * @param  array<int, mixed>  $groups
     */
    public function __construct(
        public int|float|null $count = null,
        public ?array $groups = null,
    ) {}
}
