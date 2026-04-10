<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PlaybookRun extends SpatieData
{
	public function __construct(
		#[MapName('active_stage')]
		public ?int $activeStage = null,
		#[MapName('active_stage_title')]
		public ?string $activeStageTitle = null,
		#[MapName('channel_id')]
		public ?string $channelId = null,
		public ?array $checklists = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		#[MapName('end_at')]
		public ?int $endAt = null,
		public ?string $id = null,
		#[MapName('is_active')]
		public ?bool $isActive = null,
		public ?string $name = null,
		#[MapName('owner_user_id')]
		public ?string $ownerUserId = null,
		#[MapName('playbook_id')]
		public ?string $playbookId = null,
		#[MapName('post_id')]
		public ?string $postId = null,
		public ?string $summary = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
	) {
	}
}
