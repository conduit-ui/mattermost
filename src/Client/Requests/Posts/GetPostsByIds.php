<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Posts;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * getPostsByIds
 *
 * Fetch a list of posts based on the provided postIDs
 * ##### Permissions
 * Must have `read_channel`
 * permission for the channel the post is in or if the channel is public, have the
 * `read_public_channels` permission for the team.
 */
class GetPostsByIds extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/posts/ids';
    }

    public function __construct() {}
}
