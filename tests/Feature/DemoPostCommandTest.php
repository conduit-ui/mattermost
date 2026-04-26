<?php

use ConduitUI\Mattermost\Client\Requests\Channels\GetChannelByName;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Teams\GetTeamByName;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\Testing\RecordedRequest;
use Saloon\Http\Faking\MockResponse;

describe('mattermost:demo-post', function (): void {
    beforeEach(function (): void {
        Mattermost::fake([
            GetTeamByName::class => MockResponse::make(['id' => 'team-abc-123']),
            GetChannelByName::class => MockResponse::make(['id' => 'channel-xyz-789']),
            CreatePost::class => MockResponse::make(['id' => 'post-1', 'message' => 'Hello from Laravel!']),
        ]);

        config()->set('mattermost.connections.default.team', 'my-team');
    });

    it('posts a message to the resolved channel', function (): void {
        $this->artisan('mattermost:demo-post', ['channel' => 'town-square', 'text' => 'Hello from Laravel!'])
            ->assertSuccessful();

        Mattermost::assertSent(GetTeamByName::class);
        Mattermost::assertSent(GetChannelByName::class);
        Mattermost::assertPosted(fn (RecordedRequest $r): bool => $r->get('channel_id') === 'channel-xyz-789'
            && $r->get('message') === 'Hello from Laravel!');
    });

    it('uses default channel and text when no arguments given', function (): void {
        $this->artisan('mattermost:demo-post')
            ->assertSuccessful();

        Mattermost::assertPosted(fn (RecordedRequest $r): bool => $r->get('message') === 'Hello from Laravel!');
    });

    it('accepts a --team option to override config', function (): void {
        $this->artisan('mattermost:demo-post', ['--team' => 'other-team'])
            ->assertSuccessful();

        Mattermost::assertSent(GetTeamByName::class);
        Mattermost::assertPosted();
    });

    it('fails when no team is configured', function (): void {
        config()->set('mattermost.connections.default.team', null);

        $this->artisan('mattermost:demo-post')
            ->assertFailed();

        Mattermost::assertNothingSent();
    });

    it('sends exactly one post per invocation', function (): void {
        $this->artisan('mattermost:demo-post');

        Mattermost::assertPostCount(1);
    });
});
