<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Dto;

use Spatie\LaravelData\Attributes\MapName;
use Spatie\LaravelData\Data as SpatieData;

class SamlCertificateStatus extends SpatieData
{
    public function __construct(
        #[MapName('idp_certificate_file')]
        public ?bool $idpCertificateFile = null,
        #[MapName('private_key_file')]
        public ?bool $privateKeyFile = null,
        #[MapName('public_certificate_file')]
        public ?bool $publicCertificateFile = null,
    ) {}
}
