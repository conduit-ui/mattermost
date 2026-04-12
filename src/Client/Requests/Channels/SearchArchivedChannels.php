<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchArchivedChannels
 *
 * Search archived channels on a team based on the search term provided in the request body.
 *
 * __Minimum
 * server version__: 5.18
 *
 * ##### Permissions
 * Must have the `list_team_channels` permission.
 *
 * In server
 * version 5.18 and later, a user without the `list_team_channels` permission will be able to use this
 * endpoint, with the search results limited to the channels that the user is a member of.
 */
class SearchArchivedChannels extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/channels/search_archived";
    }

    /**
     * @param  string  $teamId  Team GUID
     */
    public function __construct(
        protected string $teamId,
    ) {}
}
