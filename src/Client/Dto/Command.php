<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Command extends SpatieData
{
	public function __construct(
		#[MapName('auto_complete')]
		public ?bool $autoComplete = null,
		#[MapName('auto_complete_desc')]
		public ?string $autoCompleteDesc = null,
		#[MapName('auto_complete_hint')]
		public ?string $autoCompleteHint = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('creator_id')]
		public ?string $creatorId = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		#[MapName('display_name')]
		public ?string $displayName = null,
		#[MapName('icon_url')]
		public ?string $iconUrl = null,
		public ?string $id = null,
		public ?string $method = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
		public ?string $token = null,
		public ?string $trigger = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
		public ?string $url = null,
		public ?string $username = null,
	) {
	}
}
