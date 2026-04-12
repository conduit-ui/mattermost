<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PatchChannel
 *
 * Partially update a channel by providing only the fields you want to update. Omitted fields will not
 * be updated. The fields that can be updated are defined in the request body, all other provided
 * fields will be ignored.
 * ##### Permissions
 * If updating a public channel,
 * `manage_public_channel_members` permission is required. If updating a private channel,
 * `manage_private_channel_members` permission is required.
 */
class PatchChannel extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/patch";
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $channelId,
    ) {}
}
