<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * UpdateChannelRoles
 *
 * Update a user's roles for a channel.
 * ##### Permissions
 * Must have `manage_channel_roles` permission
 * for the channel.
 */
class UpdateChannelRoles extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/members/{$this->userId}/roles";
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
