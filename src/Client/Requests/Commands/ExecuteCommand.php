<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Commands;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ExecuteCommand
 *
 * Execute a command on a team.
 * ##### Permissions
 * Must have `use_slash_commands` permission for the
 * team the command is in.
 */
class ExecuteCommand extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/commands/execute';
    }

    public function __construct() {}
}
