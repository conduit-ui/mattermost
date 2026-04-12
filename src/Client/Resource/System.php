<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\System\GenerateSupportPacket;
use ConduitUI\Mattermost\Client\Requests\System\GetNotices;
use ConduitUI\Mattermost\Client\Requests\System\GetPing;
use ConduitUI\Mattermost\Client\Requests\System\GetSupportedTimezone;
use ConduitUI\Mattermost\Client\Requests\System\MarkNoticesViewed;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class System extends BaseResource
{
    public function markNoticesViewed(): Response
    {
        return $this->connector->send(new MarkNoticesViewed);
    }

    /**
     * @param  string  $teamId  ID of the team
     * @param  string  $clientVersion  Version of the client (desktop/mobile/web) that issues the request
     * @param  string  $locale  Client locale
     * @param  string  $client  Client type (web/mobile-ios/mobile-android/desktop)
     */
    public function getNotices(string $teamId, string $clientVersion, ?string $locale, string $client): Response
    {
        return $this->connector->send(new GetNotices($teamId, $clientVersion, $locale, $client));
    }

    /**
     * @param  bool  $getServerStatus  Check the status of the database and file storage as well
     * @param  string  $deviceId  Check whether this device id can receive push notifications
     */
    public function getPing(?bool $getServerStatus = null, ?string $deviceId = null): Response
    {
        return $this->connector->send(new GetPing($getServerStatus, $deviceId));
    }

    public function generateSupportPacket(): Response
    {
        return $this->connector->send(new GenerateSupportPacket);
    }

    public function getSupportedTimezone(): Response
    {
        return $this->connector->send(new GetSupportedTimezone);
    }
}
