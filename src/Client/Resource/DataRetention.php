<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\DataRetention\GetChannelPoliciesForUser;
use ConduitUI\Mattermost\Client\Requests\DataRetention\GetTeamPoliciesForUser;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class DataRetention extends BaseResource
{
    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  int  $page  The page to select.
     */
    public function getChannelPoliciesForUser(string $userId, ?int $page = null): Response
    {
        return $this->connector->send(new GetChannelPoliciesForUser($userId, $page));
    }

    /**
     * @param  string  $userId  The ID of the user. This can also be "me" which will point to the current user.
     * @param  int  $page  The page to select.
     */
    public function getTeamPoliciesForUser(string $userId, ?int $page = null): Response
    {
        return $this->connector->send(new GetTeamPoliciesForUser($userId, $page));
    }
}
