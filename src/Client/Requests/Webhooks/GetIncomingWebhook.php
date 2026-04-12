<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetIncomingWebhook
 *
 * Get an incoming webhook given the hook id.
 * ##### Permissions
 * `manage_webhooks` for system or
 * `manage_webhooks` for the specific team or `manage_webhooks` for the channel.
 */
class GetIncomingWebhook extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return "/api/v4/hooks/incoming/{$this->hookId}";
    }

    /**
     * @param  string  $hookId  Incoming Webhook GUID
     */
    public function __construct(
        protected string $hookId,
    ) {}
}
