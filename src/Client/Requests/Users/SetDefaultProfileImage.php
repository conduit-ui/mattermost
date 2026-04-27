<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * SetDefaultProfileImage
 *
 * Reset a user's profile image to the default avatar Mattermost generates
 * from their initials. Hits `DELETE /api/v4/users/{user_id}/image`.
 * Requires an admin-grade token when targeting another user.
 */
class SetDefaultProfileImage extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/image";
    }

    /**
     * @param  string  $userId  Target user GUID.
     */
    public function __construct(
        protected string $userId,
    ) {}
}
