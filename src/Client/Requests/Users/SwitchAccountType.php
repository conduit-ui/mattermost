<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SwitchAccountType
 *
 * Switch a user's login method from using email to OAuth2/SAML/LDAP or back to email. When switching
 * to OAuth2/SAML, account switching is not complete until the user follows the returned link and
 * completes any steps on the OAuth2/SAML service provider.
 *
 * To switch from email to OAuth2/SAML,
 * specify `current_service`, `new_service`, `email` and `password`.
 *
 * To switch from OAuth2/SAML to
 * email, specify `current_service`, `new_service`, `email` and `new_password`.
 *
 * To switch from email
 * to LDAP/AD, specify `current_service`, `new_service`, `email`, `password`, `ldap_ip` and
 * `new_password` (this is the user's LDAP password).
 *
 * To switch from LDAP/AD to email, specify
 * `current_service`, `new_service`, `ldap_ip`, `password` (this is the user's LDAP password), `email`
 * and `new_password`.
 *
 * Additionally, specify `mfa_code` when trying to switch an account on LDAP/AD or
 * email that has MFA activated.
 *
 * ##### Permissions
 * No current authentication required except when
 * switching from OAuth2/SAML to email.
 */
class SwitchAccountType extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/login/switch';
    }

    public function __construct() {}
}
