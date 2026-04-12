<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Bots;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateBot
 *
 * Create a new bot account on the system. Username is required.
 * ##### Permissions
 * Must have
 * `create_bot` permission.
 * __Minimum server version__: 5.10
 */
class CreateBot extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/bots';
    }

    public function __construct() {}
}
