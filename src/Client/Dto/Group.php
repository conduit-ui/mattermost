<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Group extends SpatieData
{
	public function __construct(
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		#[MapName('display_name')]
		public ?string $displayName = null,
		#[MapName('has_syncables')]
		public ?bool $hasSyncables = null,
		public ?string $id = null,
		public ?string $name = null,
		#[MapName('remote_id')]
		public ?string $remoteId = null,
		public ?string $source = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
