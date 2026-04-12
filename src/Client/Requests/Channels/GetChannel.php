<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannel
 *
 * Get channel from the provided channel id string.
 * ##### Permissions
 * `read_channel` permission for the
 * channel.
 */
class GetChannel extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}";
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $channelId,
    ) {}
}
