<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelUnread
 *
 * Get the total unread messages and mentions for a channel for a user.
 * ##### Permissions
 * Must be
 * logged in as user and have the `read_channel` permission, or have `edit_other_usrs` permission.
 */
class GetChannelUnread extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/channels/{$this->channelId}/unread";
    }

    /**
     * @param  string  $userId  User GUID
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $userId,
        protected string $channelId,
    ) {}
}
