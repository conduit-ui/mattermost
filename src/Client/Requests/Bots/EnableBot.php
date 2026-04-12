<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * EnableBot
 *
 * Enable a bot.
 * ##### Permissions
 * Must have `manage_bots` permission.
 * __Minimum server version__:
 * 5.10
 */
class EnableBot extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/bots/{$this->botUserId}/enable";
    }

    /**
     * @param  string  $botUserId  Bot user ID
     */
    public function __construct(
        protected string $botUserId,
    ) {}
}
