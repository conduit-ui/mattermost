<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * GetUserAccessTokens
 *
 * Get a page of user access tokens for users on the system. Does not include the actual authentication
 * tokens. Use query parameters for paging.
 *
 * __Minimum server version__: 4.7
 *
 * ##### Permissions
 * Must
 * have `manage_system` permission.
 */
class GetUserAccessTokens extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/tokens';
    }

    /**
     * @param  null|int  $page  The page to select.
     */
    public function __construct(
        protected ?int $page = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['page' => $this->page]);
    }
}
