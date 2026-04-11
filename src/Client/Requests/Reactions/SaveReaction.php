<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Reactions;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SaveReaction
 *
 * Create a reaction.
 * ##### Permissions
 * Must have `read_channel` permission for the channel the post is
 * in.
 */
class SaveReaction extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/reactions';
    }

    public function __construct() {}
}
