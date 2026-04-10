<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Scheme extends SpatieData
{
	public function __construct(
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('default_channel_admin_role')]
		public ?string $defaultChannelAdminRole = null,
		#[MapName('default_channel_user_role')]
		public ?string $defaultChannelUserRole = null,
		#[MapName('default_team_admin_role')]
		public ?string $defaultTeamAdminRole = null,
		#[MapName('default_team_user_role')]
		public ?string $defaultTeamUserRole = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		public ?string $id = null,
		public ?string $name = null,
		public ?string $scope = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
