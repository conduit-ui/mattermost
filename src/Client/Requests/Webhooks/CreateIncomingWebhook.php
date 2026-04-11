<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateIncomingWebhook
 *
 * Create an incoming webhook for a channel.
 * ##### Permissions
 * `manage_webhooks` for the team the
 * webhook is in.
 *
 * `manage_others_incoming_webhooks` for the team the webhook is in if the user is
 * different than the requester.
 */
class CreateIncomingWebhook extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/hooks/incoming';
    }

    public function __construct() {}
}
