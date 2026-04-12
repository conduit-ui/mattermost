<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * RegenOutgoingHookToken
 *
 * Regenerate the token for the outgoing webhook.
 * ##### Permissions
 * `manage_webhooks` for system or
 * `manage_webhooks` for the specific team or `manage_webhooks` for the channel.
 */
class RegenOutgoingHookToken extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return "/api/v4/hooks/outgoing/{$this->hookId}/regen_token";
    }

    /**
     * @param  string  $hookId  Outgoing webhook GUID
     */
    public function __construct(
        protected string $hookId,
    ) {}
}
