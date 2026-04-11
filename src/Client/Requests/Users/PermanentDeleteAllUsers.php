<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Users;

use Saloon\Enums\Method;
use Saloon\Http\Request;

/**
 * PermanentDeleteAllUsers
 *
 * Permanently deletes all users and all their related information, including posts.
 *
 * __Minimum server
 * version__: 5.26.0
 *
 * __Local mode only__: This endpoint is only available through [local
 * mode](https://docs.mattermost.com/administration/mmctl-cli-tool.html#local-mode).
 */
class PermanentDeleteAllUsers extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/api/v4/users';
    }

    public function __construct() {}
}
