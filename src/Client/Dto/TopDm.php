<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class TopDm extends SpatieData
{
	public function __construct(
		#[MapName('outgoing_message_count')]
		public ?int $outgoingMessageCount = null,
		#[MapName('post_count')]
		public ?int $postCount = null,
		#[MapName('second_participant')]
		public ?TopDminsightUserInformation $secondParticipant = null,
	) {
	}
}
