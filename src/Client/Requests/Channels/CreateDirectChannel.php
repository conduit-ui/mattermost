<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateDirectChannel
 *
 * Create a new direct message channel between two users.
 * ##### Permissions
 * Must be one of the two
 * users and have `create_direct_channel` permission. Having the `manage_system` permission voids the
 * previous requirements.
 */
class CreateDirectChannel extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/channels/direct';
    }

    public function __construct() {}
}
