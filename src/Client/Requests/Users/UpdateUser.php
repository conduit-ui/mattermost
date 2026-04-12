<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUser
 *
 * Update a user by providing the user object. The fields that can be updated are defined in the
 * request body, all other provided fields will be ignored. Any fields not included in the request body
 * will be set to null or reverted to default values.
 * ##### Permissions
 * Must be logged in as the user
 * being updated or have the `edit_other_users` permission.
 */
class UpdateUser extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}";
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
