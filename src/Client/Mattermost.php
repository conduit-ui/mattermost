<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client;

use ConduitUI\Mattermost\Client\Resource\Bots;
use ConduitUI\Mattermost\Client\Resource\Channels;
use ConduitUI\Mattermost\Client\Resource\Commands;
use ConduitUI\Mattermost\Client\Resource\DataRetention;
use ConduitUI\Mattermost\Client\Resource\Emoji;
use ConduitUI\Mattermost\Client\Resource\Files;
use ConduitUI\Mattermost\Client\Resource\Groups;
use ConduitUI\Mattermost\Client\Resource\Insights;
use ConduitUI\Mattermost\Client\Resource\Oauth;
use ConduitUI\Mattermost\Client\Resource\Posts;
use ConduitUI\Mattermost\Client\Resource\Preferences;
use ConduitUI\Mattermost\Client\Resource\Reactions;
use ConduitUI\Mattermost\Client\Resource\Status;
use ConduitUI\Mattermost\Client\Resource\System;
use ConduitUI\Mattermost\Client\Resource\Teams;
use ConduitUI\Mattermost\Client\Resource\Threads;
use ConduitUI\Mattermost\Client\Resource\Users;
use ConduitUI\Mattermost\Client\Resource\Webhooks;
use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;

/**
 * Mattermost API Reference
 *
 * There is also a work-in-progress [Postman API reference](https://documenter.getpostman.com/view/4508214/RW8FERUn).
 */
class Mattermost extends Connector
{
    public function __construct(
        protected string $baseUrl,
        protected string $token,
    ) {}

    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    public function defaultAuth(): ?Authenticator
    {
        return new TokenAuthenticator($this->token);
    }

    public function bots(): Bots
    {
        return new Bots($this);
    }

    public function channels(): Channels
    {
        return new Channels($this);
    }

    public function commands(): Commands
    {
        return new Commands($this);
    }

    public function dataRetention(): DataRetention
    {
        return new DataRetention($this);
    }

    public function emoji(): Emoji
    {
        return new Emoji($this);
    }

    public function files(): Files
    {
        return new Files($this);
    }

    public function groups(): Groups
    {
        return new Groups($this);
    }

    public function insights(): Insights
    {
        return new Insights($this);
    }

    public function oauth(): Oauth
    {
        return new Oauth($this);
    }

    public function posts(): Posts
    {
        return new Posts($this);
    }

    public function preferences(): Preferences
    {
        return new Preferences($this);
    }

    public function reactions(): Reactions
    {
        return new Reactions($this);
    }

    public function status(): Status
    {
        return new Status($this);
    }

    public function system(): System
    {
        return new System($this);
    }

    public function teams(): Teams
    {
        return new Teams($this);
    }

    public function threads(): Threads
    {
        return new Threads($this);
    }

    public function users(): Users
    {
        return new Users($this);
    }

    public function webhooks(): Webhooks
    {
        return new Webhooks($this);
    }
}
