<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Reactions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetBulkReactions
 *
 * Get a list of reactions made by all users to a given post.
 * ##### Permissions
 * Must have
 * `read_channel` permission for the channel the post is in.
 *
 * __Minimum server version__: 5.8
 */
class GetBulkReactions extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/posts/ids/reactions';
    }

    public function __construct() {}
}
