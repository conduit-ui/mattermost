<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * AutocompleteChannelsForTeamForSearch
 *
 * Autocomplete your channels on a team based on the search term provided in the request
 * URL.
 *
 * __Minimum server version__: 5.4
 *
 * ##### Permissions
 * Must have the `list_team_channels`
 * permission.
 */
class AutocompleteChannelsForTeamForSearch extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/channels/search_autocomplete";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  string  $name  Name or display name
     */
    public function __construct(
        protected string $teamId,
        protected string $name,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['name' => $this->name]);
    }
}
