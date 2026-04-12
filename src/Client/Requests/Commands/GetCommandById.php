<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetCommandById
 *
 * Get a command definition based on command id string.
 * ##### Permissions
 * Must have
 * `manage_slash_commands` permission for the team the command is in.
 *
 * __Minimum server version__:
 * 5.22
 */
class GetCommandById extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/commands/{$this->commandId}";
    }

    /**
     * @param  string  $commandId  ID of the command to get
     */
    public function __construct(
        protected string $commandId,
    ) {}
}
