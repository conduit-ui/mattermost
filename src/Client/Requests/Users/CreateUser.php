<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateUser
 *
 * Create a new user on the system. Password is required for email login. For other authentication
 * types such as LDAP or SAML, auth_data and auth_service fields are required.
 * ##### Permissions
 * No
 * permission required for creating email/username accounts on an open server. Auth Token is required
 * for other authentication types such as LDAP or SAML.
 */
class CreateUser extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users';
    }

    /**
     * @param  null|string  $t  Token id from an email invitation
     * @param  null|string  $iid  Token id from an invitation link
     */
    public function __construct(
        protected ?string $t = null,
        protected ?string $iid = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['t' => $this->t, 'iid' => $this->iid]);
    }
}
