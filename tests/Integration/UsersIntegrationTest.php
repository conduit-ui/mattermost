<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Mattermost as MattermostConnector;
use ConduitUI\Mattermost\Client\Requests\Users\SearchUsers;
use ConduitUI\Mattermost\Facades\Mattermost;

describe('Users integration', function (): void {
    it('returns the bot when fetching getUser("me")', function (): void {
        $response = Mattermost::users()->getUser('me');

        expect($response->status())->toBe(200);
        expect($response->json('id'))->toBe($this->credentials()->botUserId);
        expect($response->json('username'))->toBeString();
    });

    it('searches users by partial term', function (): void {
        $request = new SearchUsers;
        $request->body()->merge([
            'term' => 'integration',
            'team_id' => $this->credentials()->teamId,
        ]);

        $response = Mattermost::send($request);

        expect($response->status())->toBe(200);

        $users = $response->json();
        expect($users)->toBeArray();

        $usernames = array_map(static fn (array $u): string => (string) ($u['username'] ?? ''), $users);
        // The integration-bot we just created should match the term.
        expect($usernames)->toContain('integration-bot');
    });

    it('updates and resets a user profile photo via an admin connection', function (): void {
        $credentials = $this->credentials();

        $admin = new MattermostConnector(
            baseUrl: $credentials->baseUrl,
            token: $credentials->adminToken,
        );

        $fixture = sys_get_temp_dir().'/mm-int-avatar-'.bin2hex(random_bytes(4)).'.png';
        file_put_contents($fixture, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR4nGNgYGD4DwABBAEAfbLI3wAAAABJRU5ErkJggg==',
        ));

        try {
            $upload = $admin->users()->updateProfilePhoto($credentials->botUserId, $fixture);
            expect($upload->status())->toBe(200);

            $reset = $admin->users()->deleteProfilePhoto($credentials->botUserId);
            expect($reset->status())->toBe(200);
        } finally {
            if (is_file($fixture)) {
                unlink($fixture);
            }
        }
    });

    it('rejects a profile photo update made with the bot token', function (): void {
        // Bots cannot update their own avatar via their own token. This
        // test documents the constraint that motivates the admin-connection
        // pattern from the Multi-server section of the README.
        $fixture = sys_get_temp_dir().'/mm-int-bot-avatar-'.bin2hex(random_bytes(4)).'.png';
        file_put_contents($fixture, base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR4nGNgYGD4DwABBAEAfbLI3wAAAABJRU5ErkJggg==',
        ));

        try {
            $response = Mattermost::users()->updateProfilePhoto(
                $this->credentials()->botUserId,
                $fixture,
            );

            expect($response->failed())->toBeTrue();
            expect($response->status())->toBeGreaterThanOrEqual(400);
        } finally {
            if (is_file($fixture)) {
                unlink($fixture);
            }
        }
    });
});
