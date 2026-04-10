<?php

namespace ConduitUI\Mattermost\Client\Requests\Users;

use DateTime;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * MigrateAuthToLdap
 *
 * Migrates accounts from one authentication provider to another. For example, you can upgrade your
 * authentication provider from email to LDAP.
 * __Minimum server version__: 5.28
 * ##### Permissions
 * Must
 * have `manage_system` permission.
 */
class MigrateAuthToLdap extends Request implements HasBody
{
	use HasJsonBody;

	protected Method $method = Method::POST;


	public function resolveEndpoint(): string
	{
		return "/api/v4/users/migrate_auth/ldap";
	}


	public function __construct()
	{
	}
}
