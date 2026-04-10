<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class OutgoingWebhook extends SpatieData
{
	public function __construct(
		#[MapName('callback_urls')]
		public ?array $callbackUrls = null,
		#[MapName('channel_id')]
		public ?string $channelId = null,
		#[MapName('content_type')]
		public ?string $contentType = null,
		#[MapName('create_at')]
		public ?int $createAt = null,
		#[MapName('creator_id')]
		public ?string $creatorId = null,
		#[MapName('delete_at')]
		public ?int $deleteAt = null,
		public ?string $description = null,
		#[MapName('display_name')]
		public ?string $displayName = null,
		public ?string $id = null,
		#[MapName('team_id')]
		public ?string $teamId = null,
		#[MapName('trigger_when')]
		public ?int $triggerWhen = null,
		#[MapName('trigger_words')]
		public ?array $triggerWords = null,
		#[MapName('update_at')]
		public ?int $updateAt = null,
	) {
	}
}
