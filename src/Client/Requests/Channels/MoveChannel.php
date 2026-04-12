<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * MoveChannel
 *
 * Move a channel to another team.
 *
 * __Minimum server version__: 5.26
 *
 * ##### Permissions
 *
 * Must have
 * `manage_system` permission.
 */
class MoveChannel extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/move";
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $channelId,
    ) {}
}
