<?php

use ConduitUI\Mattermost\Testing\MattermostFixtures;

describe('MattermostFixtures::post()', function (): void {
    it('returns a realistic post shape', function (): void {
        $post = MattermostFixtures::post();

        expect($post)
            ->toHaveKeys(['id', 'create_at', 'channel_id', 'user_id', 'message', 'props'])
            ->and($post['id'])->toHaveLength(26)
            ->and($post['message'])->toBe('hello world');
    });

    it('merges overrides on top of defaults', function (): void {
        $post = MattermostFixtures::post([
            'message' => 'custom',
            'channel_id' => 'channel-1',
        ]);

        expect($post['message'])->toBe('custom')
            ->and($post['channel_id'])->toBe('channel-1')
            ->and($post['id'])->toHaveLength(26);
    });
});

describe('MattermostFixtures::user()', function (): void {
    it('returns a realistic user shape with username override', function (): void {
        $user = MattermostFixtures::user(['username' => 'jordan']);

        expect($user)
            ->toHaveKeys(['id', 'username', 'email', 'roles', 'is_bot'])
            ->and($user['username'])->toBe('jordan')
            ->and($user['is_bot'])->toBeFalse();
    });
});

describe('MattermostFixtures::channel()', function (): void {
    it('returns a public channel shape by default', function (): void {
        $channel = MattermostFixtures::channel();

        expect($channel['type'])->toBe('O')
            ->and($channel['name'])->toBe('town-square');
    });
});

describe('MattermostFixtures::team()', function (): void {
    it('returns a team with default name', function (): void {
        $team = MattermostFixtures::team();

        expect($team['type'])->toBe('O')
            ->and($team['name'])->toBe('test-team');
    });
});

describe('MattermostFixtures::reaction()', function (): void {
    it('returns a reaction with overrideable emoji', function (): void {
        $reaction = MattermostFixtures::reaction(['emoji_name' => 'tada']);

        expect($reaction['emoji_name'])->toBe('tada')
            ->and($reaction)->toHaveKeys(['user_id', 'post_id', 'create_at']);
    });
});

describe('MattermostFixtures::websocketEvent()', function (): void {
    it('wraps data in the WebSocket event envelope', function (): void {
        $event = MattermostFixtures::websocketEvent('posted', ['post' => '...']);

        expect($event)
            ->toHaveKeys(['event', 'data', 'broadcast', 'seq'])
            ->and($event['event'])->toBe('posted')
            ->and($event['data']['post'])->toBe('...');
    });
});

describe('MattermostFixtures::fakeDirectMessage()', function (): void {
    it('produces a posted event for a direct channel', function (): void {
        $event = MattermostFixtures::fakeDirectMessage('hi there');

        expect($event['event'])->toBe('posted')
            ->and($event['data']['channel_type'])->toBe('D');

        $post = json_decode((string) $event['data']['post'], true);
        expect($post['message'])->toBe('hi there');
    });
});

describe('MattermostFixtures::fakeMention()', function (): void {
    it('includes the bot username in mentions', function (): void {
        $event = MattermostFixtures::fakeMention('@bot help', botUsername: 'bot');

        expect($event['event'])->toBe('posted');

        $mentions = json_decode((string) $event['data']['mentions'], true);
        expect($mentions)->toBe(['bot']);
    });
});

describe('MattermostFixtures::fakeFileShare()', function (): void {
    it('attaches file ids to the post', function (): void {
        $event = MattermostFixtures::fakeFileShare(['file-1', 'file-2'], message: 'see attached');

        $post = json_decode((string) $event['data']['post'], true);
        expect($post['file_ids'])->toBe(['file-1', 'file-2'])
            ->and($post['message'])->toBe('see attached');
    });
});

describe('MattermostFixtures::fakeSlashCommand()', function (): void {
    it('builds a slash command payload', function (): void {
        $payload = MattermostFixtures::fakeSlashCommand('deploy', 'staging');

        expect($payload['command'])->toBe('/deploy')
            ->and($payload['text'])->toBe('staging')
            ->and($payload)->toHaveKeys(['user_id', 'channel_id', 'response_url', 'trigger_id']);
    });

    it('preserves an explicit leading slash', function (): void {
        $payload = MattermostFixtures::fakeSlashCommand('/deploy');

        expect($payload['command'])->toBe('/deploy');
    });
});

describe('MattermostFixtures::fakeButtonClick()', function (): void {
    it('builds an interactive button payload', function (): void {
        $payload = MattermostFixtures::fakeButtonClick('approve', 'yes', ['plan_id' => '42']);

        expect($payload['action'])->toBe('approve')
            ->and($payload['value'])->toBe('yes')
            ->and($payload['context'])->toBe(['action' => 'approve', 'plan_id' => '42']);
    });
});

describe('MattermostFixtures::id()', function (): void {
    it('returns 26-character lowercase ids', function (): void {
        $id = MattermostFixtures::id();

        expect($id)->toHaveLength(26)
            ->and($id)->toMatch('/^[a-z0-9]{26}$/');
    });
});
