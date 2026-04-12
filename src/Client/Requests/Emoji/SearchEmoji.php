<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Emoji;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * SearchEmoji
 *
 * Search for custom emoji by name based on search criteria provided in the request body. A maximum of
 * 200 results are returned.
 * ##### Permissions
 * Must be authenticated.
 *
 * __Minimum server version__: 4.7
 */
class SearchEmoji extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/emoji/search';
    }

    public function __construct() {}
}
