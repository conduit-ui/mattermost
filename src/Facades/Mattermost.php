<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Facades;

use ConduitUI\Mattermost\MattermostManager;
use Illuminate\Support\Facades\Facade;

/**
 * @method static \ConduitUI\Mattermost\Client\Mattermost connection(?string $name = null)
 * @method static \ConduitUI\Mattermost\Client\Resource\Posts posts()
 * @method static \ConduitUI\Mattermost\Client\Resource\Channels channels()
 * @method static \ConduitUI\Mattermost\Client\Resource\Users users()
 * @method static \ConduitUI\Mattermost\Client\Resource\Teams teams()
 * @method static \ConduitUI\Mattermost\Client\Resource\Files files()
 * @method static \ConduitUI\Mattermost\Client\Resource\Reactions reactions()
 * @method static \ConduitUI\Mattermost\Client\Resource\Bots bots()
 * @method static \ConduitUI\Mattermost\Client\Resource\Webhooks webhooks()
 * @method static \ConduitUI\Mattermost\Client\Resource\Commands commands()
 * @method static \ConduitUI\Mattermost\Client\Resource\Emoji emoji()
 * @method static \ConduitUI\Mattermost\Client\Resource\Status status()
 * @method static \ConduitUI\Mattermost\Client\Resource\System system()
 *
 * @see MattermostManager
 * @see \ConduitUI\Mattermost\Client\Mattermost
 */
class Mattermost extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MattermostManager::class;
    }

    /**
     * Proxy calls to the default connection's connector.
     *
     * @param  array<int, mixed>  $args
     */
    #[\Override]
    public static function __callStatic($method, $args): mixed
    {
        $manager = static::getFacadeRoot();

        // If the method exists on the manager, call it
        if (method_exists($manager, $method)) {
            return $manager->$method(...$args);
        }

        // Otherwise proxy to the default connection (the Saloon connector)
        return $manager->connection()->$method(...$args);
    }
}
