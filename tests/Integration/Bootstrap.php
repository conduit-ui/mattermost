<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Tests\Integration;

use Override;
use RuntimeException;
use Saloon\Contracts\Body\HasBody;
use Saloon\Enums\Method;
use Saloon\Http\Connector;
use Saloon\Http\Request;
use Saloon\Traits\Body\HasJsonBody;

/**
 * Bootstrap helper that turns a fresh Mattermost server into a usable
 * test environment.
 *
 * On first run against a clean server this will:
 *   1. Create the first admin user (first user is auto-promoted to admin).
 *   2. Log in as that admin and capture the session token.
 *   3. Create a default team (idempotent — fetched if it already exists).
 *   4. Resolve the auto-created `town-square` channel for that team.
 *   5. Create a bot user.
 *   6. Issue a personal access token for the bot.
 *
 * On subsequent runs everything is idempotent: if the admin already exists
 * we log in instead of recreating, the team is fetched by name, and an
 * existing bot is detected and reused with a fresh PAT.
 *
 * We use raw Saloon requests here (not the auto-generated client) so that
 * bootstrap stays usable even if there's a bug somewhere in the generated
 * client surface — bootstrap is the floor the suite stands on.
 */
final class Bootstrap
{
    private const string ADMIN_EMAIL = 'admin@integration.test';

    private const string ADMIN_USERNAME = 'integration-admin';

    private const string ADMIN_PASSWORD = 'IntegrationTest123!';

    private const string TEAM_NAME = 'integration-team';

    private const string TEAM_DISPLAY = 'Integration Team';

    private const string BOT_USERNAME = 'integration-bot';

    private const string BOT_DISPLAY = 'Integration Bot';

    private static ?Credentials $cached = null;

    public static function reset(): void
    {
        self::$cached = null;
    }

    public static function ensure(string $baseUrl): Credentials
    {
        if (self::$cached instanceof Credentials && self::$cached->baseUrl === $baseUrl) {
            return self::$cached;
        }

        $admin = self::ensureAdmin($baseUrl);
        $teamId = self::ensureTeam($baseUrl, $admin->sessionToken);
        $channelId = self::resolveTownSquare($baseUrl, $admin->sessionToken, $teamId);
        [$botUserId, $botToken] = self::ensureBot($baseUrl, $admin->sessionToken);

        self::ensureBotOnTeam($baseUrl, $admin->sessionToken, $teamId, $botUserId);
        self::ensureBotInChannel($baseUrl, $admin->sessionToken, $channelId, $botUserId);

        return self::$cached = new Credentials(
            baseUrl: $baseUrl,
            adminToken: $admin->sessionToken,
            adminUserId: $admin->userId,
            botToken: $botToken,
            botUserId: $botUserId,
            teamId: $teamId,
            channelId: $channelId,
        );
    }

    private static function ensureAdmin(string $baseUrl): AdminSession
    {
        $connector = new RawConnector($baseUrl);

        // Try login first — idempotent on re-runs.
        $login = self::login($connector, self::ADMIN_EMAIL, self::ADMIN_PASSWORD);

        if ($login instanceof AdminSession) {
            return $login;
        }

        // Login failed — create the admin.
        $response = $connector->send(new RawRequest(Method::POST, '/api/v4/users', [
            'email' => self::ADMIN_EMAIL,
            'username' => self::ADMIN_USERNAME,
            'password' => self::ADMIN_PASSWORD,
        ]));

        if ($response->status() >= 400) {
            throw new RuntimeException(
                'Failed to create admin user: '.$response->status().' '.$response->body()
            );
        }

        $session = self::login($connector, self::ADMIN_EMAIL, self::ADMIN_PASSWORD);

        if (! $session instanceof AdminSession) {
            throw new RuntimeException('Failed to log in as freshly created admin');
        }

        return $session;
    }

    private static function login(RawConnector $connector, string $email, string $password): ?AdminSession
    {
        $response = $connector->send(new RawRequest(Method::POST, '/api/v4/users/login', [
            'login_id' => $email,
            'password' => $password,
        ]));

        if ($response->status() >= 400) {
            return null;
        }

        $token = $response->header('Token');

        if (! is_string($token) || $token === '') {
            return null;
        }

        $userId = $response->json('id');

        if (! is_string($userId)) {
            return null;
        }

        return new AdminSession(userId: $userId, sessionToken: $token);
    }

    private static function ensureTeam(string $baseUrl, string $token): string
    {
        $connector = new RawConnector($baseUrl, $token);

        $get = $connector->send(new RawRequest(Method::GET, '/api/v4/teams/name/'.self::TEAM_NAME));

        if ($get->status() < 400) {
            $id = $get->json('id');

            if (is_string($id)) {
                return $id;
            }
        }

        $create = $connector->send(new RawRequest(Method::POST, '/api/v4/teams', [
            'name' => self::TEAM_NAME,
            'display_name' => self::TEAM_DISPLAY,
            'type' => 'O',
        ]));

        if ($create->status() >= 400) {
            throw new RuntimeException(
                'Failed to create team: '.$create->status().' '.$create->body()
            );
        }

        $id = $create->json('id');

        if (! is_string($id)) {
            throw new RuntimeException('Team create response missing id');
        }

        return $id;
    }

    private static function resolveTownSquare(string $baseUrl, string $token, string $teamId): string
    {
        $connector = new RawConnector($baseUrl, $token);

        $response = $connector->send(new RawRequest(
            Method::GET,
            '/api/v4/teams/'.$teamId.'/channels/name/town-square'
        ));

        if ($response->status() >= 400) {
            throw new RuntimeException(
                'Failed to resolve town-square channel: '.$response->status().' '.$response->body()
            );
        }

        $id = $response->json('id');

        if (! is_string($id)) {
            throw new RuntimeException('town-square response missing id');
        }

        return $id;
    }

    /**
     * @return array{0: string, 1: string} [botUserId, botToken]
     */
    private static function ensureBot(string $baseUrl, string $adminToken): array
    {
        $connector = new RawConnector($baseUrl, $adminToken);

        $existing = $connector->send(new RawRequest(
            Method::GET,
            '/api/v4/users/username/'.self::BOT_USERNAME
        ));

        $botUserId = null;

        if ($existing->status() < 400) {
            $id = $existing->json('id');

            if (is_string($id)) {
                $botUserId = $id;
            }
        }

        if ($botUserId === null) {
            $create = $connector->send(new RawRequest(Method::POST, '/api/v4/bots', [
                'username' => self::BOT_USERNAME,
                'display_name' => self::BOT_DISPLAY,
                'description' => 'Integration test bot',
            ]));

            if ($create->status() >= 400) {
                throw new RuntimeException(
                    'Failed to create bot: '.$create->status().' '.$create->body()
                );
            }

            $id = $create->json('user_id');

            if (! is_string($id)) {
                throw new RuntimeException('Bot create response missing user_id');
            }

            $botUserId = $id;
        }

        // Issue a fresh personal access token. Mattermost only stores the
        // hash, so previous tokens cannot be retrieved across reruns.
        $tokenResp = $connector->send(new RawRequest(
            Method::POST,
            '/api/v4/users/'.$botUserId.'/tokens',
            ['description' => 'integration-suite-'.bin2hex(random_bytes(4))],
        ));

        if ($tokenResp->status() >= 400) {
            throw new RuntimeException(
                'Failed to issue bot token: '.$tokenResp->status().' '.$tokenResp->body()
            );
        }

        $token = $tokenResp->json('token');

        if (! is_string($token)) {
            throw new RuntimeException('Bot token response missing token');
        }

        return [$botUserId, $token];
    }

    private static function ensureBotOnTeam(string $baseUrl, string $adminToken, string $teamId, string $botUserId): void
    {
        $connector = new RawConnector($baseUrl, $adminToken);

        // POSTing a duplicate membership returns 400-ish — we don't care
        // either way as long as the bot ends up on the team.
        $connector->send(new RawRequest(
            Method::POST,
            '/api/v4/teams/'.$teamId.'/members',
            ['team_id' => $teamId, 'user_id' => $botUserId],
        ));
    }

    private static function ensureBotInChannel(string $baseUrl, string $adminToken, string $channelId, string $botUserId): void
    {
        $connector = new RawConnector($baseUrl, $adminToken);

        $connector->send(new RawRequest(
            Method::POST,
            '/api/v4/channels/'.$channelId.'/members',
            ['user_id' => $botUserId],
        ));
    }
}

/**
 * @internal
 */
final class AdminSession
{
    public function __construct(
        public readonly string $userId,
        public readonly string $sessionToken,
    ) {}
}

/**
 * @internal
 */
final class Credentials
{
    public function __construct(
        public readonly string $baseUrl,
        public readonly string $adminToken,
        public readonly string $adminUserId,
        public readonly string $botToken,
        public readonly string $botUserId,
        public readonly string $teamId,
        public readonly string $channelId,
    ) {}
}

/**
 * @internal Tiny Saloon connector used only for bootstrap calls so we
 * don't dogfood the auto-gen client during setup.
 */
final class RawConnector extends Connector
{
    public function __construct(
        private readonly string $baseUrl,
        private readonly ?string $token = null,
    ) {}

    #[Override]
    public function resolveBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @return array<string, string>
     */
    protected function defaultHeaders(): array
    {
        $headers = ['Accept' => 'application/json'];

        if ($this->token !== null) {
            $headers['Authorization'] = 'Bearer '.$this->token;
        }

        return $headers;
    }
}

/**
 * @internal Generic JSON request used during bootstrap. Body is optional
 * (GETs leave it empty) — the connector still attaches the auth header.
 */
final class RawRequest extends Request implements HasBody
{
    use HasJsonBody;

    /**
     * @param  array<string, mixed>  $payload
     */
    public function __construct(
        protected Method $method,
        private readonly string $endpoint,
        private readonly array $payload = [],
    ) {}

    #[Override]
    public function resolveEndpoint(): string
    {
        return $this->endpoint;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return $this->payload;
    }
}
