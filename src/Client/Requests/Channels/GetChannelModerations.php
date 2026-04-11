<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelModerations
 *
 * ##### Permissions
 * Must have `manage_system` permission.
 *
 * __Minimum server version__: 5.22
 */
class GetChannelModerations extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/moderations";
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $channelId,
    ) {}
}
