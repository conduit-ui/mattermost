<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class Config extends SpatieData
{
    public function __construct(
        #[MapName('AnalyticsSettings')]
        public ?object $analyticsSettings = null,
        #[MapName('ClusterSettings')]
        public ?object $clusterSettings = null,
        #[MapName('ComplianceSettings')]
        public ?object $complianceSettings = null,
        #[MapName('EmailSettings')]
        public ?object $emailSettings = null,
        #[MapName('FileSettings')]
        public ?object $fileSettings = null,
        #[MapName('GitLabSettings')]
        public ?object $gitLabSettings = null,
        #[MapName('GoogleSettings')]
        public ?object $googleSettings = null,
        #[MapName('LdapSettings')]
        public ?object $ldapSettings = null,
        #[MapName('LocalizationSettings')]
        public ?object $localizationSettings = null,
        #[MapName('LogSettings')]
        public ?object $logSettings = null,
        #[MapName('MetricsSettings')]
        public ?object $metricsSettings = null,
        #[MapName('NativeAppSettings')]
        public ?object $nativeAppSettings = null,
        #[MapName('Office365Settings')]
        public ?object $office365settings = null,
        #[MapName('PasswordSettings')]
        public ?object $passwordSettings = null,
        #[MapName('PrivacySettings')]
        public ?object $privacySettings = null,
        #[MapName('RateLimitSettings')]
        public ?object $rateLimitSettings = null,
        #[MapName('SamlSettings')]
        public ?object $samlSettings = null,
        #[MapName('ServiceSettings')]
        public ?object $serviceSettings = null,
        #[MapName('SqlSettings')]
        public ?object $sqlSettings = null,
        #[MapName('SupportSettings')]
        public ?object $supportSettings = null,
        #[MapName('TeamSettings')]
        public ?object $teamSettings = null,
    ) {}
}
