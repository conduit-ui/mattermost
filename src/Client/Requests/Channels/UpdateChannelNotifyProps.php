<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateChannelNotifyProps
 *
 * Update a user's notification properties for a channel. Only the provided fields are updated.
 * #####
 * Permissions
 * Must be logged in as the user or have `edit_other_users` permission.
 */
class UpdateChannelNotifyProps extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/members/{$this->userId}/notify_props";
    }

    /**
     * @param  string  $channelId  Channel GUID
     * @param  string  $userId  User GUID
     */
    public function __construct(
        protected string $channelId,
        protected string $userId,
    ) {}
}
