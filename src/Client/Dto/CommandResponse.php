<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class CommandResponse extends SpatieData
{
	public function __construct(
		#[MapName('Attachments')]
		public ?array $attachments = null,
		#[MapName('GotoLocation')]
		public ?string $gotoLocation = null,
		#[MapName('IconURL')]
		public ?string $iconUrl = null,
		#[MapName('ResponseType')]
		public ?string $responseType = null,
		#[MapName('Text')]
		public ?string $text = null,
		#[MapName('Username')]
		public ?string $username = null,
	) {
	}
}
