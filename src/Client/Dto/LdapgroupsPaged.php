<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Data as SpatieData;

/**
 * A paged list of LDAP groups
 */
class LdapgroupsPaged extends SpatieData
{
	public function __construct(
		public int|float|null $count = null,
		public ?array $groups = null,
	) {
	}
}
