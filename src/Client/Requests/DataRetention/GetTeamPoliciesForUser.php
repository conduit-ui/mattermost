<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\DataRetention;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetTeamPoliciesForUser
 *
 * Gets the policies which are applied to the all of the teams to which a user belongs.
 *
 * __Minimum
 * server version__: 5.35
 *
 * ##### Permissions
 * Must be logged in as the user or have the `manage_system`
 * permission.
 *
 * ##### License
 * Requires an E20 license.
 */
class GetTeamPoliciesForUser extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/users/{$this->userId}/data_retention/team_policies";
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  null|int  $page  The page to select.
     */
    public function __construct(
        protected string $userId,
        protected ?int $page = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page]);
    }
}
