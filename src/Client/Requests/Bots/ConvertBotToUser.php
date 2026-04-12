<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * ConvertBotToUser
 *
 * Convert a bot into a user.
 *
 * __Minimum server version__: 5.26
 *
 * ##### Permissions
 * Must have
 * `manage_system` permission.
 */
class ConvertBotToUser extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/bots/{$this->botUserId}/convert_to_user";
    }

    /**
     * @param  string  $botUserId  Bot user ID
     * @param  null|bool  $setSystemAdmin  Whether to give the user the system admin role.
     */
    public function __construct(
        protected string $botUserId,
        protected ?bool $setSystemAdmin = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['set_system_admin' => $this->setSystemAdmin]);
    }
}
