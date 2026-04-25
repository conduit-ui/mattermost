<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Integration;

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\Tests\TestCase;
use Throwable;

/**
 * Base test case for integration tests against a real Mattermost server.
 *
 * Behaviour contract:
 *
 *   - If `MATTERMOST_URL` env is empty OR the server doesn't respond to
 *     `/api/v4/system/ping` within ~3 seconds, every test in the suite is
 *     marked skipped. This is what keeps `vendor/bin/pest --compact` green
 *     for local devs who don't run `docker compose up -d`.
 *
 *   - When the server IS up, the first test triggers `Bootstrap::ensure()`
 *     which lazily creates the admin/team/bot/token. The result is memoised
 *     on the static `Bootstrap` cache so subsequent tests reuse it within
 *     the process.
 *
 *   - The default Mattermost connection is rebuilt to point at the real
 *     server with the bot token so `Mattermost::posts()->createPost(...)`
 *     and friends work via the facade for free.
 */
abstract class IntegrationTestCase extends TestCase
{
    protected static ?string $skipReason = null;

    protected ?Credentials $credentials = null;

    protected function setUp(): void
    {
        parent::setUp();

        $url = self::resolveBaseUrl();

        if ($url === null) {
            $this->markTestSkipped('Set MATTERMOST_URL to run integration tests (e.g. http://localhost:8065).');
        }

        if (! self::pingable($url)) {
            $this->markTestSkipped("Mattermost not reachable at {$url} — start it via `docker compose up -d` and wait ~30s for first-run init.");
        }

        try {
            $this->credentials = Bootstrap::ensure($url);
        } catch (Throwable $error) {
            $this->markTestSkipped('Mattermost bootstrap failed: '.$error->getMessage());
        }

        // Reconfigure the default connection so the facade + manager point
        // at the real server with the freshly-issued bot token.
        config(['mattermost.connections.default' => [
            'url' => $this->credentials->baseUrl,
            'token' => $this->credentials->botToken,
            'bot_user_id' => $this->credentials->botUserId,
        ]]);

        // Drop any cached connection from prior tests in this process.
        $this->app->make(MattermostManager::class)->purge();
    }

    protected function client(): Mattermost
    {
        return $this->app->make(MattermostManager::class)->connection();
    }

    protected function credentials(): Credentials
    {
        if (! $this->credentials instanceof Credentials) {
            $this->fail('Integration credentials missing — setUp should have populated them.');
        }

        return $this->credentials;
    }

    /**
     * Resolve the base URL. Honours `MATTERMOST_URL` env / phpunit env;
     * trims trailing slash for consistency.
     */
    public static function resolveBaseUrl(): ?string
    {
        $candidates = [getenv('MATTERMOST_URL'), $_ENV['MATTERMOST_URL'] ?? null, $_SERVER['MATTERMOST_URL'] ?? null];

        foreach ($candidates as $candidate) {
            if (is_string($candidate) && $candidate !== '') {
                return rtrim($candidate, '/');
            }
        }

        return null;
    }

    /**
     * Cheap reachability probe — bounded by a short timeout so the test
     * suite skips cleanly instead of hanging when nothing's listening.
     */
    public static function pingable(string $baseUrl): bool
    {
        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 3,
                'ignore_errors' => true,
            ],
        ]);

        $body = @file_get_contents($baseUrl.'/api/v4/system/ping', false, $context);

        return is_string($body) && str_contains($body, 'OK');
    }
}
