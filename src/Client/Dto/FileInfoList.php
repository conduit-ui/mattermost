<?php

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class FileInfoList extends SpatieData
{
	public function __construct(
		#[MapName('file_infos')]
		public ?object $fileInfos = null,
		#[MapName('next_file_id')]
		public ?string $nextFileId = null,
		public ?array $order = null,
		#[MapName('prev_file_id')]
		public ?string $prevFileId = null,
	) {
	}
}
