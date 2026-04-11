<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Teams;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * AddTeamMembers
 *
 * Add a number of users to the team by user_id.
 * ##### Permissions
 * Must be authenticated. Authenticated
 * user must have the `add_user_to_team` permission.
 */
class AddTeamMembers extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/teams/{$this->teamId}/members/batch";
    }

    /**
     * @param  string  $teamId  Team GUID
     * @param  null|bool  $graceful  Instead of aborting the operation if a user cannot be added, return an arrray that will contain both the success and added members and the ones with error, in form of `[{"member": {...}, "user_id", "...", "error": {...}}]`
     */
    public function __construct(
        protected string $teamId,
        protected ?bool $graceful = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['graceful' => $this->graceful]);
    }
}
