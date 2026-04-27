<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Testing;

use Closure;
use ConduitUI\Mattermost\Client\Mattermost as MattermostConnector;
use ConduitUI\Mattermost\Client\Requests\Files\UploadFile;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Posts\DeletePost;
use ConduitUI\Mattermost\Client\Requests\Posts\PatchPost;
use ConduitUI\Mattermost\Client\Requests\Posts\UpdatePost;
use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use ConduitUI\Mattermost\Client\Requests\Users\SetDefaultProfileImage;
use ConduitUI\Mattermost\Client\Requests\Users\SetProfileImage;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\MattermostManager;
use PHPUnit\Framework\Assert as PHPUnit;
use RuntimeException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\PendingRequest;

/**
 * Test double for the {@see MattermostManager}. Wraps each connection in a
 * Saloon {@see MockClient} so no real HTTP traffic is sent, and records each
 * outgoing request as a {@see RecordedRequest} so tests can assert on them.
 *
 * Use directly when you need a recorder without touching the container, or
 * call {@see Mattermost::fake()} to swap the
 * binding in one shot.
 */
class MattermostFake extends MattermostManager
{
    /** @var array<int, RecordedRequest> */
    protected array $recorded = [];

    /** @var array<string, MattermostConnector> */
    protected array $fakeConnections = [];

    protected bool $preventStrayPosts = false;

    /**
     * Build a fake. Optional default responses can be provided keyed by
     * request class to override the default empty 200 response.
     *
     * @param  array<class-string, MockResponse|Closure(PendingRequest):MockResponse>  $defaultResponses
     */
    public function __construct(protected array $defaultResponses = []) {}

    #[\Override]
    public function connection(?string $name = null): MattermostConnector
    {
        $name ??= $this->resolveDefaultConnectionName();

        if (isset($this->fakeConnections[$name])) {
            return $this->fakeConnections[$name];
        }

        $connector = new MattermostConnector(
            baseUrl: 'https://fake.mattermost.test',
            token: 'fake-token',
        );

        $connector->withMockClient($this->buildMockClient());

        $self = $this;
        $connector->middleware()->onRequest(
            static function (PendingRequest $pendingRequest) use ($self, $name): void {
                $self->record(RecordedRequest::fromPendingRequest($pendingRequest, $name));
            },
            'mattermost-fake-recorder',
        );

        return $this->fakeConnections[$name] = $connector;
    }

    #[\Override]
    public function purge(?string $name = null): void
    {
        if ($name === null) {
            $this->fakeConnections = [];

            return;
        }

        unset($this->fakeConnections[$name]);
    }

    /**
     * Register the default response returned for a given request class.
     * Useful when bot logic reads the JSON body it just "posted".
     *
     * @param  class-string  $requestClass
     * @param  MockResponse|Closure(PendingRequest):MockResponse  $response
     */
    public function setResponse(string $requestClass, MockResponse|Closure $response): self
    {
        $this->defaultResponses[$requestClass] = $response;

        // Force connections to be rebuilt so the new default applies.
        $this->fakeConnections = [];

        return $this;
    }

    /**
     * Cause any recorded post to fail the test. Mirrors Laravel's
     * Notification::fake() preventStrayNotifications().
     */
    public function preventStrayPosts(bool $prevent = true): self
    {
        $this->preventStrayPosts = $prevent;

        return $this;
    }

    public function record(RecordedRequest $record): void
    {
        if ($this->preventStrayPosts && $record->isFor(CreatePost::class)) {
            PHPUnit::fail(sprintf(
                'A stray Mattermost post was sent to channel [%s] with message [%s].',
                (string) ($record->get('channel_id') ?? 'unknown'),
                (string) ($record->get('message') ?? ''),
            ));
        }

        $this->recorded[] = $record;
    }

    /**
     * Get every recorded request — optionally filter to a particular Saloon
     * request class.
     *
     * @param  class-string|null  $requestClass
     * @return array<int, RecordedRequest>
     */
    public function recorded(?string $requestClass = null): array
    {
        if ($requestClass === null) {
            return $this->recorded;
        }

        return array_values(array_filter(
            $this->recorded,
            static fn (RecordedRequest $record): bool => $record->isFor($requestClass),
        ));
    }

    /**
     * Reset all captured state.
     */
    public function flush(): self
    {
        $this->recorded = [];
        $this->fakeConnections = [];

        return $this;
    }

    // ------------------------------------------------------------------
    // Generic assertions
    // ------------------------------------------------------------------

    /**
     * Assert a request matching the given class or callback was sent.
     *
     * @param  class-string|Closure(RecordedRequest):bool  $value
     */
    public function assertSent(string|Closure $value, ?int $times = null): self
    {
        $matches = $this->matching($value);

        if ($times !== null) {
            PHPUnit::assertCount(
                $times,
                $matches,
                sprintf('Expected %d matching Mattermost requests, found %d.', $times, count($matches)),
            );

            return $this;
        }

        PHPUnit::assertNotEmpty($matches, 'No matching Mattermost request was sent.');

        return $this;
    }

    /**
     * @param  class-string|Closure(RecordedRequest):bool  $value
     */
    public function assertNotSent(string|Closure $value): self
    {
        $matches = $this->matching($value);

        PHPUnit::assertEmpty($matches, 'An unexpected Mattermost request was sent.');

        return $this;
    }

    public function assertNothingSent(): self
    {
        PHPUnit::assertEmpty(
            $this->recorded,
            sprintf('Expected no Mattermost requests, but %d were recorded.', count($this->recorded)),
        );

        return $this;
    }

    // ------------------------------------------------------------------
    // Posts API
    // ------------------------------------------------------------------

    /**
     * Assert a CreatePost was sent. The optional callback receives the
     * RecordedRequest so consumers can read message/channel from the body.
     *
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertPosted(?Closure $callback = null, ?int $times = null): self
    {
        return $this->assertSentForRequest(CreatePost::class, $callback, $times, 'No matching Mattermost post was created.');
    }

    /**
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertNotPosted(?Closure $callback = null): self
    {
        return $this->assertNotSentForRequest(CreatePost::class, $callback, 'An unexpected Mattermost post was created.');
    }

    public function assertNothingPosted(): self
    {
        $count = count($this->recorded(CreatePost::class));

        PHPUnit::assertSame(
            0,
            $count,
            sprintf('Expected no Mattermost posts, but %d were created.', $count),
        );

        return $this;
    }

    public function assertPostCount(int $expected): self
    {
        $count = count($this->recorded(CreatePost::class));

        PHPUnit::assertSame(
            $expected,
            $count,
            sprintf('Expected %d Mattermost posts, but %d were created.', $expected, $count),
        );

        return $this;
    }

    /**
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertUpdated(?Closure $callback = null, ?int $times = null): self
    {
        return $this->assertSentForRequest(UpdatePost::class, $callback, $times, 'No matching Mattermost update was sent.');
    }

    /**
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertPatched(?Closure $callback = null, ?int $times = null): self
    {
        return $this->assertSentForRequest(PatchPost::class, $callback, $times, 'No matching Mattermost patch was sent.');
    }

    /**
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertDeleted(?Closure $callback = null, ?int $times = null): self
    {
        return $this->assertSentForRequest(DeletePost::class, $callback, $times, 'No matching Mattermost delete was sent.');
    }

    // ------------------------------------------------------------------
    // Reactions API
    // ------------------------------------------------------------------

    /**
     * Assert a reaction was added — optionally narrow by post id and emoji.
     */
    public function assertReacted(?string $postId = null, ?string $emoji = null): self
    {
        $callback = static function (RecordedRequest $record) use ($postId, $emoji): bool {
            if ($postId !== null && $record->get('post_id') !== $postId) {
                return false;
            }

            if ($emoji !== null && $record->get('emoji_name') !== $emoji) {
                return false;
            }

            return true;
        };

        return $this->assertSentForRequest(SaveReaction::class, $callback, null, sprintf(
            'No matching Mattermost reaction was sent (post_id=%s emoji=%s).',
            $postId ?? '*',
            $emoji ?? '*',
        ));
    }

    public function assertNotReacted(?string $postId = null, ?string $emoji = null): self
    {
        $callback = static function (RecordedRequest $record) use ($postId, $emoji): bool {
            if ($postId !== null && $record->get('post_id') !== $postId) {
                return false;
            }

            if ($emoji !== null && $record->get('emoji_name') !== $emoji) {
                return false;
            }

            return true;
        };

        return $this->assertNotSentForRequest(SaveReaction::class, $callback, 'An unexpected Mattermost reaction was sent.');
    }

    // ------------------------------------------------------------------
    // Files API
    // ------------------------------------------------------------------

    /**
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertFileUploaded(?Closure $callback = null, ?int $times = null): self
    {
        return $this->assertSentForRequest(UploadFile::class, $callback, $times, 'No matching Mattermost file upload was sent.');
    }

    // ------------------------------------------------------------------
    // Users API
    // ------------------------------------------------------------------

    /**
     * Assert a profile-photo update was sent. Optionally narrow by user id
     * or with a callback receiving the RecordedRequest.
     *
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertProfilePhotoUpdated(?string $userId = null, ?Closure $callback = null, ?int $times = null): self
    {
        $combined = static function (RecordedRequest $record) use ($userId, $callback): bool {
            if ($userId !== null && ! str_contains($record->url, "/users/{$userId}/image")) {
                return false;
            }

            return $callback === null || $callback($record);
        };

        return $this->assertSentForRequest(SetProfileImage::class, $combined, $times, sprintf(
            'No matching Mattermost profile-photo update was sent (user_id=%s).',
            $userId ?? '*',
        ));
    }

    /**
     * Assert the default-image (DELETE) reset was sent.
     *
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    public function assertProfilePhotoReset(?string $userId = null, ?Closure $callback = null, ?int $times = null): self
    {
        $combined = static function (RecordedRequest $record) use ($userId, $callback): bool {
            if ($userId !== null && ! str_contains($record->url, "/users/{$userId}/image")) {
                return false;
            }

            return $callback === null || $callback($record);
        };

        return $this->assertSentForRequest(SetDefaultProfileImage::class, $combined, $times, sprintf(
            'No matching Mattermost profile-photo reset was sent (user_id=%s).',
            $userId ?? '*',
        ));
    }

    // ------------------------------------------------------------------
    // Internals
    // ------------------------------------------------------------------

    /**
     * @param  class-string|Closure(RecordedRequest):bool  $value
     * @return array<int, RecordedRequest>
     */
    protected function matching(string|Closure $value): array
    {
        if (is_string($value)) {
            return $this->recorded($value);
        }

        return array_values(array_filter($this->recorded, $value));
    }

    /**
     * @param  class-string  $requestClass
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    protected function assertSentForRequest(string $requestClass, ?Closure $callback, ?int $times, string $failureMessage): self
    {
        $matches = $this->recorded($requestClass);

        if ($callback instanceof Closure) {
            $matches = array_values(array_filter($matches, $callback));
        }

        if ($times !== null) {
            PHPUnit::assertCount($times, $matches, $failureMessage);

            return $this;
        }

        PHPUnit::assertNotEmpty($matches, $failureMessage);

        return $this;
    }

    /**
     * @param  class-string  $requestClass
     * @param  Closure(RecordedRequest):bool|null  $callback
     */
    protected function assertNotSentForRequest(string $requestClass, ?Closure $callback, string $failureMessage): self
    {
        $matches = $this->recorded($requestClass);

        if ($callback instanceof Closure) {
            $matches = array_values(array_filter($matches, $callback));
        }

        PHPUnit::assertEmpty($matches, $failureMessage);

        return $this;
    }

    protected function buildMockClient(): MockClient
    {
        $responses = [];

        foreach ($this->defaultResponses as $requestClass => $response) {
            $responses[$requestClass] = $response;
        }

        // Fallback: any URL we haven't explicitly mocked returns an empty 200.
        $responses['*'] = MockResponse::make([]);

        return new MockClient($responses);
    }

    protected function resolveDefaultConnectionName(): string
    {
        if (function_exists('config')) {
            $name = config('mattermost.default', 'default');

            if (! is_string($name) || $name === '') {
                throw new RuntimeException('Mattermost default connection name must be a non-empty string.');
            }

            return $name;
        }

        return 'default';
    }
}
