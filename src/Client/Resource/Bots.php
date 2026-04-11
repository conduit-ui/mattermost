<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Bots\AssignBot;
use ConduitUI\Mattermost\Client\Requests\Bots\ConvertBotToUser;
use ConduitUI\Mattermost\Client\Requests\Bots\ConvertUserToBot;
use ConduitUI\Mattermost\Client\Requests\Bots\CreateBot;
use ConduitUI\Mattermost\Client\Requests\Bots\DisableBot;
use ConduitUI\Mattermost\Client\Requests\Bots\EnableBot;
use ConduitUI\Mattermost\Client\Requests\Bots\GetBot;
use ConduitUI\Mattermost\Client\Requests\Bots\GetBots;
use ConduitUI\Mattermost\Client\Requests\Bots\PatchBot;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Bots extends BaseResource
{
    /**
     * @param  int  $page  The page to select.
     * @param  bool  $includeDeleted  If deleted bots should be returned.
     * @param  bool  $onlyOrphaned  When true, only orphaned bots will be returned. A bot is consitered orphaned if it's owner has been deactivated.
     */
    public function getBots(?int $page = null, ?bool $includeDeleted = null, ?bool $onlyOrphaned = null): Response
    {
        return $this->connector->send(new GetBots($page, $includeDeleted, $onlyOrphaned));
    }

    public function createBot(): Response
    {
        return $this->connector->send(new CreateBot);
    }

    /**
     * @param  string  $botUserId  Bot user ID
     * @param  bool  $includeDeleted  If deleted bots should be returned.
     */
    public function getBot(string $botUserId, ?bool $includeDeleted = null): Response
    {
        return $this->connector->send(new GetBot($botUserId, $includeDeleted));
    }

    /**
     * @param  string  $botUserId  Bot user ID
     */
    public function patchBot(string $botUserId): Response
    {
        return $this->connector->send(new PatchBot($botUserId));
    }

    /**
     * @param  string  $botUserId  Bot user ID
     * @param  string  $userId  The user ID to assign the bot to.
     */
    public function assignBot(string $botUserId, string $userId): Response
    {
        return $this->connector->send(new AssignBot($botUserId, $userId));
    }

    /**
     * @param  string  $botUserId  Bot user ID
     * @param  bool  $setSystemAdmin  Whether to give the user the system admin role.
     */
    public function convertBotToUser(string $botUserId, ?bool $setSystemAdmin = null): Response
    {
        return $this->connector->send(new ConvertBotToUser($botUserId, $setSystemAdmin));
    }

    /**
     * @param  string  $botUserId  Bot user ID
     */
    public function disableBot(string $botUserId): Response
    {
        return $this->connector->send(new DisableBot($botUserId));
    }

    /**
     * @param  string  $botUserId  Bot user ID
     */
    public function enableBot(string $botUserId): Response
    {
        return $this->connector->send(new EnableBot($botUserId));
    }

    /**
     * @param  string  $userId  User GUID
     */
    public function convertUserToBot(string $userId): Response
    {
        return $this->connector->send(new ConvertUserToBot($userId));
    }
}
