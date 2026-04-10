<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PropertyField extends SpatieData
{
	public function __construct(
		public ?object $attrs = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		public ?string $id = null,
		public ?string $name = null,
		public ?string $type = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
