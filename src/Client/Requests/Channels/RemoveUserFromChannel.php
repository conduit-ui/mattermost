<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * RemoveUserFromChannel
 *
 * Delete a channel member, effectively removing them from a channel.
 *
 * In server version 5.3 and later,
 * channel members can only be deleted from public or private channels.
 * #####
 * Permissions
 * `manage_public_channel_members` permission if the channel is
 * public.
 * `manage_private_channel_members` permission if the channel is private.
 */
class RemoveUserFromChannel extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/members/{$this->userId}";
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
