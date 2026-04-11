<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PatchChannelModerations
 *
 * ##### Permissions
 * Must have `manage_system` permission.
 *
 * __Minimum server version__: 5.22
 */
class PatchChannelModerations extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/moderations/patch";
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $channelId,
    ) {}
}
