<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreatePostEphemeral
 *
 * Create a new ephemeral post in a channel.
 * ##### Permissions
 * Must have `create_post_ephemeral`
 * permission (currently only given to system admin)
 */
class CreatePostEphemeral extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/posts/ephemeral';
    }

    public function __construct() {}
}
