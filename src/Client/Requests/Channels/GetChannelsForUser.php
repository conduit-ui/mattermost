<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelsForUser
 *
 * Get all channels from all teams that a user is a member of.
 *
 * __Minimum server version__: 6.1
 *
 * #####
 * Permissions
 *
 * Logged in as the user, or have `edit_other_users` permission.
 */
class GetChannelsForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/channels";
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  null|int  $lastDeleteAt  Filters the deleted channels by this time in epoch format. Does not have any effect if include_deleted is set to false.
     * @param  null|bool  $includeDeleted  Defines if deleted channels should be returned or not
     */
    public function __construct(
        protected string $userId,
        protected ?int $lastDeleteAt = null,
        protected ?bool $includeDeleted = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['last_delete_at' => $this->lastDeleteAt, 'include_deleted' => $this->includeDeleted]);
    }
}
