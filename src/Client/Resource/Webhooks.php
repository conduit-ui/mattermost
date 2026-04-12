<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client\Resource;

use ConduitUI\Mattermost\Client\Requests\Webhooks\CreateIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\CreateOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\DeleteIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\DeleteOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetIncomingWebhooks;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetOutgoingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\GetOutgoingWebhooks;
use ConduitUI\Mattermost\Client\Requests\Webhooks\RegenOutgoingHookToken;
use ConduitUI\Mattermost\Client\Requests\Webhooks\UpdateIncomingWebhook;
use ConduitUI\Mattermost\Client\Requests\Webhooks\UpdateOutgoingWebhook;
use Saloon\Http\BaseResource;
use Saloon\Http\Response;

class Webhooks extends BaseResource
{
    /**
     * @param  int  $page  The page to select.
     * @param  string  $teamId  The ID of the team to get hooks for.
     */
    public function getIncomingWebhooks(?int $page = null, ?string $teamId = null): Response
    {
        return $this->connector->send(new GetIncomingWebhooks($page, $teamId));
    }

    public function createIncomingWebhook(): Response
    {
        return $this->connector->send(new CreateIncomingWebhook);
    }

    /**
     * @param  string  $hookId  Incoming Webhook GUID
     */
    public function getIncomingWebhook(string $hookId): Response
    {
        return $this->connector->send(new GetIncomingWebhook($hookId));
    }

    /**
     * @param  string  $hookId  Incoming Webhook GUID
     */
    public function updateIncomingWebhook(string $hookId): Response
    {
        return $this->connector->send(new UpdateIncomingWebhook($hookId));
    }

    /**
     * @param  string  $hookId  Incoming webhook GUID
     */
    public function deleteIncomingWebhook(string $hookId): Response
    {
        return $this->connector->send(new DeleteIncomingWebhook($hookId));
    }

    /**
     * @param  int  $page  The page to select.
     * @param  string  $teamId  The ID of the team to get hooks for.
     * @param  string  $channelId  The ID of the channel to get hooks for.
     */
    public function getOutgoingWebhooks(?int $page = null, ?string $teamId = null, ?string $channelId = null): Response
    {
        return $this->connector->send(new GetOutgoingWebhooks($page, $teamId, $channelId));
    }

    public function createOutgoingWebhook(): Response
    {
        return $this->connector->send(new CreateOutgoingWebhook);
    }

    /**
     * @param  string  $hookId  Outgoing webhook GUID
     */
    public function getOutgoingWebhook(string $hookId): Response
    {
        return $this->connector->send(new GetOutgoingWebhook($hookId));
    }

    /**
     * @param  string  $hookId  outgoing Webhook GUID
     */
    public function updateOutgoingWebhook(string $hookId): Response
    {
        return $this->connector->send(new UpdateOutgoingWebhook($hookId));
    }

    /**
     * @param  string  $hookId  Outgoing webhook GUID
     */
    public function deleteOutgoingWebhook(string $hookId): Response
    {
        return $this->connector->send(new DeleteOutgoingWebhook($hookId));
    }

    /**
     * @param  string  $hookId  Outgoing webhook GUID
     */
    public function regenOutgoingHookToken(string $hookId): Response
    {
        return $this->connector->send(new RegenOutgoingHookToken($hookId));
    }
}
