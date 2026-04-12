<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * GetUsersByIds
 *
 * Get a list of users based on a provided list of user ids.
 * ##### Permissions
 * Requires an active
 * session but no other permissions.
 */
class GetUsersByIds extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users/ids';
    }

    /**
     * @param  null|int  $since  Only return users that have been modified since the given Unix timestamp (in milliseconds).
     *
     * __Minimum server version__: 5.14
     */
    public function __construct(
        protected ?int $since = null,
    ) {}

    public function defaultQuery(): array
    {
        return array_filter(['since' => $this->since]);
    }
}
