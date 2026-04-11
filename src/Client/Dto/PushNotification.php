<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class PushNotification extends SpatieData
{
    public function __construct(
        #[MapName('ack_id')]
        public ?string $ackId = null,
        public int|float|null $badge = null,
        public ?string $category = null,
        #[MapName('channel_id')]
        public ?string $channelId = null,
        #[MapName('channel_name')]
        public ?string $channelName = null,
        #[MapName('cont_ava')]
        public int|float|null $contAva = null,
        #[MapName('device_id')]
        public ?string $deviceId = null,
        #[MapName('from_webhook')]
        public ?string $fromWebhook = null,
        #[MapName('is_id_loaded')]
        public ?bool $isIdLoaded = null,
        public ?string $message = null,
        #[MapName('override_icon_url')]
        public ?string $overrideIconUrl = null,
        #[MapName('override_username')]
        public ?string $overrideUsername = null,
        public ?string $platform = null,
        #[MapName('post_id')]
        public ?string $postId = null,
        #[MapName('root_id')]
        public ?string $rootId = null,
        #[MapName('sender_id')]
        public ?string $senderId = null,
        #[MapName('sender_name')]
        public ?string $senderName = null,
        #[MapName('server_id')]
        public ?string $serverId = null,
        public ?string $sound = null,
        #[MapName('team_id')]
        public ?string $teamId = null,
        public ?string $type = null,
        public ?string $version = null,
    ) {}
}
