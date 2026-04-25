<?php

declare(strict_types=1);

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
});
