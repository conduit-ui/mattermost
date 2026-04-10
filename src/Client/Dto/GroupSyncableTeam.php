<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class GroupSyncableTeam extends SpatieData
{
	public function __construct(
		#[MapName('auto_add')]
		public ?bool $autoAdd = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		#[MapName('group_id')]
		public ?string $groupId = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
