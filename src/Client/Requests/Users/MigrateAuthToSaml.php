<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * MigrateAuthToSaml
 *
 * Migrates accounts from one authentication provider to another. For example, you can upgrade your
 * authentication provider from email to SAML.
 * __Minimum server version__: 5.28
 * ##### Permissions
 * Must
 * have `manage_system` permission.
 */
class MigrateAuthToSaml extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/migrate_auth/saml';
    }

    public function __construct() {}
}
