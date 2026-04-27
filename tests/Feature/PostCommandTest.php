<?php

use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelByName;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamByName;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\Testing\RecordedRequest;
use Saloon\Http\Faking\MockResponse;

describe('mattermost:post', function (): void {
    it('posts a message when given a channel ID directly', function (): void {
        Mattermost::fake([
            CreatePost::class => MockResponse::make(['id' => 'post-1', 'message' => 'Hello']),
        ]);

        $this->artisan('mattermost:post', [
            'channel' => 'abcdefghijklmnopqrstuvwxyz',
            'message' => 'Hello',
        ])->assertSuccessful();

        Mattermost::assertNotSent(GetTeamByName::class);
        Mattermost::assertPosted(fn (RecordedRequest $r): bool => $r->get('channel_id') === 'abcdefghijklmnopqrstuvwxyz'
            && $r->get('message') === 'Hello');
    });

    it('resolves channel by name when given a non-ID string', function (): void {
        Mattermost::fake([
            GetTeamByName::class => MockResponse::make(['id' => 'team-abc-123']),
            GetChannelByName::class => MockResponse::make(['id' => 'channel-xyz-789']),
            CreatePost::class => MockResponse::make(['id' => 'post-1', 'message' => 'Hi']),
        ]);

        config()->set('mattermost.connections.default.team', 'my-team');

        $this->artisan('mattermost:post', [
            'channel' => 'town-square',
            'message' => 'Hi',
        ])->assertSuccessful();

        Mattermost::assertSent(GetTeamByName::class);
        Mattermost::assertSent(GetChannelByName::class);
        Mattermost::assertPosted(fn (RecordedRequest $r): bool => $r->get('channel_id') === 'channel-xyz-789');
    });

    it('fails when channel name given but no team configured', function (): void {
        Mattermost::fake();
        config()->set('mattermost.connections.default.team', null);

        $this->artisan('mattermost:post', [
            'channel' => 'town-square',
            'message' => 'Hi',
        ])->assertFailed();

        Mattermost::assertNothingSent();
    });

    it('accepts a --team option to override config', function (): void {
        Mattermost::fake([
            GetTeamByName::class => MockResponse::make(['id' => 'other-team-id']),
            GetChannelByName::class => MockResponse::make(['id' => 'ch-id']),
            CreatePost::class => MockResponse::make(['id' => 'post-1']),
        ]);

        $this->artisan('mattermost:post', [
            'channel' => 'general',
            'message' => 'Test',
            '--team' => 'other-team',
        ])->assertSuccessful();

        Mattermost::assertSent(GetTeamByName::class);
        Mattermost::assertPosted();
    });

    it('sends exactly one post per invocation', function (): void {
        Mattermost::fake([
            CreatePost::class => MockResponse::make(['id' => 'post-1']),
        ]);

        $this->artisan('mattermost:post', [
            'channel' => 'abcdefghijklmnopqrstuvwxyz',
            'message' => 'Single post',
        ]);

        Mattermost::assertPostCount(1);
    });
});
