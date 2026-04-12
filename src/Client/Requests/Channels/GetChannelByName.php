<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetChannelByName
 *
 * Gets channel from the provided team id and channel name strings.
 * ##### Permissions
 * `read_channel`
 * permission for the channel.
 */
class GetChannelByName extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/channels/name/{$this->channelName}";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $channelName  Channel Name
     * @param  null|bool  $includeDeleted  Defines if deleted channels should be returned or not (Mattermost Server 5.26.0+)
     */
    public function __construct(
        protected string $teamId,
        protected string $channelName,
        protected ?bool $includeDeleted = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['include_deleted' => $this->includeDeleted]);
    }
}
