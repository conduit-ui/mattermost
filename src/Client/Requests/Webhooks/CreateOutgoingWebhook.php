<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Webhooks;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateOutgoingWebhook
 *
 * Create an outgoing webhook for a team.
 * ##### Permissions
 * `manage_webhooks` for the team the webhook
 * is in.
 *
 * `manage_others_outgoing_webhooks` for the team the webhook is in if the user is different
 * than the requester.
 */
class CreateOutgoingWebhook extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/hooks/outgoing';
    }

    public function __construct() {}
}
