<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SystemStatusResponse extends SpatieData
{
    public function __construct(
        #[MapName('AndroidLatestVersion')]
        public ?string $androidLatestVersion = null,
        #[MapName('AndroidMinVersion')]
        public ?string $androidMinVersion = null,
        #[MapName('CanReceiveNotifications')]
        public ?string $canReceiveNotifications = null,
        #[MapName('DesktopLatestVersion')]
        public ?string $desktopLatestVersion = null,
        #[MapName('DesktopMinVersion')]
        public ?string $desktopMinVersion = null,
        #[MapName('IosLatestVersion')]
        public ?string $iosLatestVersion = null,
        #[MapName('IosMinVersion')]
        public ?string $iosMinVersion = null,
        #[MapName('database_status')]
        public ?string $databaseStatus = null,
        #[MapName('filestore_status')]
        public ?string $filestoreStatus = null,
        public ?string $status = null,
    ) {}
}
