<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\Notifications\MattermostChannel;
use ConduitUI\Mattermost\Notifications\MattermostMessage;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Notification;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;

beforeEach(function (): void {
    $this->mock = MockClient::global([
        CreatePost::class => MockResponse::make(['id' => 'post-1', 'message' => 'ok'], 201),
    ]);

    config(['mattermost.connections.staging' => [
        'url' => 'https://staging.mm.test',
        'token' => 'staging-token',
    ]]);
});

afterEach(function (): void {
    MockClient::destroyGlobal();
});

describe('MattermostChannel', function (): void {
    it('posts a string message returned from toMattermost', function (): void {
        $channel = app(MattermostChannel::class);

        $notifiable = (new AnonymousNotifiable)->route('mattermost', 'channel-id-123');

        $notification = new class extends Notification
        {
            public function toMattermost(mixed $notifiable): array
            {
                return ['message' => 'deploy complete'];
            }
        };

        $channel->send($notifiable, $notification);

        $this->mock->assertSent(CreatePost::class);

        $body = $this->mock->getLastPendingRequest()?->body()?->all();
        expect($body)->toBe([
            'channel_id' => 'channel-id-123',
            'message' => 'deploy complete',
        ]);
    });

    it('posts a MattermostMessage value object', function (): void {
        $channel = app(MattermostChannel::class);

        $notifiable = (new AnonymousNotifiable)->route('mattermost', 'channel-id-123');

        $notification = new class extends Notification
        {
            public function toMattermost(mixed $notifiable): MattermostMessage
            {
                return MattermostMessage::create('release shipped')
                    ->attachments([['text' => 'version 1.2.3']]);
            }
        };

        $channel->send($notifiable, $notification);

        $body = $this->mock->getLastPendingRequest()?->body()?->all();
        expect($body['channel_id'])->toBe('channel-id-123');
        expect($body['message'])->toBe('release shipped');
        expect($body['props'])->toBe(['attachments' => [['text' => 'version 1.2.3']]]);
    });

    it('honors connection name from route array', function (): void {
        $channel = app(MattermostChannel::class);
        $manager = app(MattermostManager::class);

        // Touch the default connection so we can see staging gets used after.
        $defaultConnector = $manager->connection();

        $notifiable = (new AnonymousNotifiable)->route('mattermost', [
            'channel' => 'staging-channel',
            'connection' => 'staging',
        ]);

        $notification = new class extends Notification
        {
            public function toMattermost(mixed $notifiable): array
            {
                return ['message' => 'hello staging'];
            }
        };

        $channel->send($notifiable, $notification);

        $stagingConnector = $manager->connection('staging');
        expect($stagingConnector->resolveBaseUrl())->toBe('https://staging.mm.test');
        expect($stagingConnector)->not->toBe($defaultConnector);

        $body = $this->mock->getLastPendingRequest()?->body()?->all();
        expect($body['channel_id'])->toBe('staging-channel');
    });

    it('prefers channel id set on the MattermostMessage over the route', function (): void {
        $channel = app(MattermostChannel::class);

        $notifiable = (new AnonymousNotifiable)->route('mattermost', 'route-channel');

        $notification = new class extends Notification
        {
            public function toMattermost(mixed $notifiable): MattermostMessage
            {
                return MattermostMessage::create('explicit')->channel('explicit-channel');
            }
        };

        $channel->send($notifiable, $notification);

        $body = $this->mock->getLastPendingRequest()?->body()?->all();
        expect($body['channel_id'])->toBe('explicit-channel');
    });

    it('is a no-op when toMattermost is not defined', function (): void {
        $channel = app(MattermostChannel::class);

        $notifiable = (new AnonymousNotifiable)->route('mattermost', 'channel-id-123');

        $notification = new class extends Notification {};

        $channel->send($notifiable, $notification);

        $this->mock->assertNothingSent();
    });

    it('throws when no channel id is resolvable', function (): void {
        $channel = app(MattermostChannel::class);

        $notifiable = new AnonymousNotifiable; // no route configured

        $notification = new class extends Notification
        {
            public function toMattermost(mixed $notifiable): array
            {
                return ['message' => 'orphan message'];
            }
        };

        $channel->send($notifiable, $notification);
    })->throws(RuntimeException::class, 'channel id');
});
