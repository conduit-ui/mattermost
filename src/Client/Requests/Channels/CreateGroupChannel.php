<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Requests\Channels;

use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * CreateGroupChannel
 *
 * Create a new group message channel to group of users. If the logged in user's id is not included in
 * the list, it will be appended to the end.
 * ##### Permissions
 * Must have `create_group_channel`
 * permission.
 */
class CreateGroupChannel extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/api/v4/channels/group';
    }

    public function __construct() {}
}
