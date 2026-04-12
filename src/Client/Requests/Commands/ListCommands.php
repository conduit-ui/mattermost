<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * ListCommands
 *
 * List commands for a team.
 * ##### Permissions
 * `manage_slash_commands` if need list custom commands.
 */
class ListCommands extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/commands';
    }

    /**
     * @param  null|string  $teamId  The team id.
     * @param  null|bool  $customOnly  To get only the custom commands. If set to false will get the custom
     *                                 if the user have access plus the system commands, otherwise just the system commands.
     */
    public function __construct(
        protected ?string $teamId = null,
        protected ?bool $customOnly = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['team_id' => $this->teamId, 'custom_only' => $this->customOnly]);
    }
}
