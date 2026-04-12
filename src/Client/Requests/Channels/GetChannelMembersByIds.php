<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetChannelMembersByIds
 *
 * Get a list of channel members based on the provided user ids.
 * ##### Permissions
 * Must have the
 * `read_channel` permission.
 */
class GetChannelMembersByIds extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/channels/{$this->channelId}/members/ids";
    }

    /**
     * @param  string  $channelId  Channel GUID
     */
    public function __construct(
        protected string $channelId,
    ) {}
}
