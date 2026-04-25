<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Facades;

use Closure;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\Testing\MattermostFake;
use Illuminate\Support\Facades\Facade;
use Saloon\Http\Faking\MockResponse;

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
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertSent(string|\Closure $value, ?int $times = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertNotSent(string|\Closure $value)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertNothingSent()
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertPosted(?\Closure $callback = null, ?int $times = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertNotPosted(?\Closure $callback = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertNothingPosted()
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertPostCount(int $expected)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertUpdated(?\Closure $callback = null, ?int $times = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertPatched(?\Closure $callback = null, ?int $times = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertDeleted(?\Closure $callback = null, ?int $times = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertReacted(?string $postId = null, ?string $emoji = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertNotReacted(?string $postId = null, ?string $emoji = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake assertFileUploaded(?\Closure $callback = null, ?int $times = null)
 * @method static \ConduitUI\Mattermost\Testing\MattermostFake preventStrayPosts(bool $prevent = true)
 * @method static array<int, \ConduitUI\Mattermost\Testing\RecordedRequest> recorded(?string $requestClass = null)
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
     * Swap the bound MattermostManager for a recording fake. Call this at the
     * top of a test, then make assertions via the facade or the returned fake.
     *
     * @param  array<class-string, MockResponse|Closure>  $defaultResponses
     */
    public static function fake(array $defaultResponses = []): MattermostFake
    {
        $fake = new MattermostFake($defaultResponses);

        static::swap($fake);

        return $fake;
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
