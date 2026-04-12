<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Oauth\GetAuthorizedOauthAppsForUser;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Oauth extends BaseResource
{
    /**
     * @param  string  $userId  User GUID
     * @param  int  $page  The page to select.
     */
    public function getAuthorizedOauthAppsForUser(string $userId, ?int $page = null): Response
    {
        return $this->connector->send(new GetAuthorizedOauthAppsForUser($userId, $page));
    }
}
