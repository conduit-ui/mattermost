<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * MoveCommand
 *
 * Move a command to a different team based on command id string.
 * ##### Permissions
 * Must have
 * `manage_slash_commands` permission for the team the command is currently in and the destination
 * team.
 *
 * __Minimum server version__: 5.22
 */
class MoveCommand extends Request
{
    protected Method $method = Method::PUT;

    public function resolveEndpoint(): string
    {
        return "/api/v4/commands/{$this->commandId}/move";
    }

    /**
     * @param  string  $commandId  ID of the command to move
     */
    public function __construct(
        protected string $commandId,
    ) {}
}
