<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Status;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateUserCustomStatus
 *
 * Updates a user's custom status by setting the value in the user's props and updates the user. Also
 * save the given custom status to the recent custom statuses in the user's props
 * #####
 * Permissions
 * Must be logged in as the user whose custom status is being updated.
 */
class UpdateUserCustomStatus extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/status/custom";
    }

    /**
     * @param  string  $userId  User ID
     */
    public function __construct(
        protected string $userId,
    ) {}
}
