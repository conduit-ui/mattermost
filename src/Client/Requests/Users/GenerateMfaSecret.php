<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GenerateMfaSecret
 *
 * Generates an multi-factor authentication secret for a user and returns it as a string and as base64
 * encoded QR code image.
 * ##### Permissions
 * Must be logged in as the user or have the
 * `edit_other_users` permission.
 */
class GenerateMfaSecret extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/mfa/generate";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
