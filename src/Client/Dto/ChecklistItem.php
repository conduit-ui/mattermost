<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class ChecklistItem extends SpatieData
{
	public function __construct(
		#[MapName('assignee_id')]
		public ?string $assigneeId = null,
		#[MapName('assignee_modified')]
		public ?int $assigneeModified = null,
		public ?string $command = null,
		#[MapName('command_last_run')]
		public ?int $commandLastRun = null,
		#[MapName('condition_action')]
		public ?string $conditionAction = null,
		#[MapName('condition_id')]
		public ?string $conditionId = null,
		#[MapName('condition_reason')]
		public ?string $conditionReason = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		#[MapName('due_date')]
		public ?int $dueDate = null,
		public ?string $id = null,
		public ?string $state = null,
		#[MapName('state_modified')]
		public ?int $stateModified = null,
		#[MapName('task_actions')]
		public ?array $taskActions = null,
		public ?string $title = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
