<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Team extends SpatieData
{
	public function __construct(
		#[MapName('allow_open_invite')]
		public ?bool $allowOpenInvite = null,
		#[MapName('allowed_domains')]
		public ?string $allowedDomains = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		#[MapName('display_name')]
		public ?string $displayName = null,
		public ?string $email = null,
		public ?string $id = null,
		#[MapName('invite_id')]
		public ?string $inviteId = null,
		public ?string $name = null,
		#[MapName('policy_id')]
		public ?string $policyId = null,
		public ?string $type = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
