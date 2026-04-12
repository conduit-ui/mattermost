<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateEmoji
 *
 * Create a custom emoji for the team.
 * ##### Permissions
 * Must be authenticated.
 */
class CreateEmoji extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/emoji';
    }

    public function __construct() {}
}
