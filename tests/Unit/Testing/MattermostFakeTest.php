<?php

use ConduitUI\Mattermost\Client\Requests\Files\UploadFile;
use ConduitUI\Mattermost\Client\Requests\Posts\CreatePost;
use ConduitUI\Mattermost\Client\Requests\Posts\DeletePost;
use ConduitUI\Mattermost\Client\Requests\Posts\PatchPost;
use ConduitUI\Mattermost\Client\Requests\Posts\UpdatePost;
use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use ConduitUI\Mattermost\Facades\Mattermost;
use ConduitUI\Mattermost\MattermostManager;
use ConduitUI\Mattermost\Testing\MattermostFake;
use ConduitUI\Mattermost\Testing\MattermostFixtures;
use ConduitUI\Mattermost\Testing\RecordedRequest;
use PHPUnit\Framework\AssertionFailedError;
use Saloon\Http\Faking\MockResponse;

describe('Mattermost::fake()', function (): void {
    it('swaps the manager binding for a fake recorder', function (): void {
        $fake = Mattermost::fake();

        expect($fake)->toBeInstanceOf(MattermostFake::class);
        expect(app(MattermostManager::class))->toBe($fake);
    });

    it('returns a Mattermost connector that does not hit the network', function (): void {
        Mattermost::fake();

        $request = (new CreatePost)->body()->merge([
            'channel_id' => 'channel-1',
            'message' => 'hello',
        ]);

        // No exception means the MockClient intercepted the request.
        $response = Mattermost::posts()->createPost();

        expect($response->status())->toBe(200);
        expect($request)->not->toBeNull();
    });
});

describe('Post assertions', function (): void {
    it('assertPosted matches by closure on the recorded payload', function (): void {
        $fake = Mattermost::fake();

        $connector = Mattermost::connection();
        $request = new CreatePost;
        $request->body()->merge([
            'channel_id' => 'town-square',
            'message' => 'deployed',
        ]);
        $connector->send($request);

        $fake->assertPosted(
            fn (RecordedRequest $record): bool => $record->get('channel_id') === 'town-square'
                && str_contains((string) $record->get('message'), 'deployed'),
        );
    });

    it('assertPosted via the facade also works', function (): void {
        Mattermost::fake();

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'general', 'message' => 'hi']);
        Mattermost::connection()->send($request);

        Mattermost::assertPosted();
    });

    it('assertPosted fails when no matching post was sent', function (): void {
        Mattermost::fake();

        Mattermost::assertPosted();
    })->throws(AssertionFailedError::class);

    it('assertNothingPosted passes when no posts were sent', function (): void {
        Mattermost::fake();

        Mattermost::assertNothingPosted();
    });

    it('assertNothingPosted fails when posts were sent', function (): void {
        Mattermost::fake();

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'c', 'message' => 'oops']);
        Mattermost::connection()->send($request);

        Mattermost::assertNothingPosted();
    })->throws(AssertionFailedError::class);

    it('assertPostCount matches the number of posts', function (): void {
        Mattermost::fake();

        for ($i = 0; $i < 3; $i++) {
            $request = new CreatePost;
            $request->body()->merge(['channel_id' => 'c', 'message' => "msg {$i}"]);
            Mattermost::connection()->send($request);
        }

        Mattermost::assertPostCount(3);
    });

    it('assertNotPosted with a callback fails when matching post exists', function (): void {
        Mattermost::fake();

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'general', 'message' => 'banned word']);
        Mattermost::connection()->send($request);

        Mattermost::assertNotPosted(
            fn (RecordedRequest $r): bool => str_contains((string) $r->get('message'), 'banned'),
        );
    })->throws(AssertionFailedError::class);

    it('assertUpdated tracks UpdatePost requests', function (): void {
        Mattermost::fake();

        Mattermost::posts()->updatePost('post-123');

        Mattermost::assertUpdated();
        Mattermost::assertSent(UpdatePost::class);
    });

    it('assertPatched tracks PatchPost requests', function (): void {
        Mattermost::fake();

        Mattermost::posts()->patchPost('post-123');

        Mattermost::assertPatched();
        Mattermost::assertSent(PatchPost::class);
    });

    it('assertDeleted tracks DeletePost requests', function (): void {
        Mattermost::fake();

        Mattermost::posts()->deletePost('post-456');

        Mattermost::assertDeleted();
        Mattermost::assertSent(DeletePost::class);
    });
});

describe('preventStrayPosts', function (): void {
    it('fails the test if any unexpected post is sent', function (): void {
        $fake = Mattermost::fake();
        $fake->preventStrayPosts();

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'c', 'message' => 'stray']);
        Mattermost::connection()->send($request);
    })->throws(AssertionFailedError::class, 'stray Mattermost post');
});

describe('Reaction assertions', function (): void {
    it('assertReacted matches by post id and emoji', function (): void {
        Mattermost::fake();

        $request = new SaveReaction;
        $request->body()->merge([
            'user_id' => 'user-1',
            'post_id' => 'post-99',
            'emoji_name' => 'white_check_mark',
        ]);
        Mattermost::connection()->send($request);

        Mattermost::assertReacted('post-99', 'white_check_mark');
    });

    it('assertReacted fails on emoji mismatch', function (): void {
        Mattermost::fake();

        $request = new SaveReaction;
        $request->body()->merge([
            'user_id' => 'user-1',
            'post_id' => 'post-99',
            'emoji_name' => 'thumbsup',
        ]);
        Mattermost::connection()->send($request);

        Mattermost::assertReacted('post-99', 'white_check_mark');
    })->throws(AssertionFailedError::class);

    it('assertNotReacted passes when no reactions were sent', function (): void {
        Mattermost::fake();

        Mattermost::assertNotReacted();
    });
});

describe('File assertions', function (): void {
    it('assertFileUploaded tracks UploadFile requests', function (): void {
        Mattermost::fake();

        Mattermost::files()->uploadFile('channel-1', 'foo.txt');

        Mattermost::assertFileUploaded();
        Mattermost::assertSent(UploadFile::class);
    });
});

describe('Default responses', function (): void {
    it('returns the configured default response for a request class', function (): void {
        Mattermost::fake([
            CreatePost::class => MockResponse::make(MattermostFixtures::post(['message' => 'hi']), 201),
        ]);

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'c', 'message' => 'hi']);

        $response = Mattermost::connection()->send($request);

        expect($response->status())->toBe(201);
        expect($response->json('message'))->toBe('hi');
    });
});

describe('flush()', function (): void {
    it('clears all recorded requests', function (): void {
        $fake = Mattermost::fake();

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'c', 'message' => 'hi']);
        Mattermost::connection()->send($request);

        $fake->flush();

        Mattermost::assertNothingPosted();
        expect($fake->recorded())->toBeEmpty();
    });
});

describe('Standalone (no fake() swap) usage', function (): void {
    it('records when used directly without container swap', function (): void {
        $fake = new MattermostFake;

        $request = new CreatePost;
        $request->body()->merge(['channel_id' => 'c', 'message' => 'standalone']);
        $fake->connection('default')->send($request);

        $fake->assertPosted(
            fn (RecordedRequest $r): bool => $r->get('message') === 'standalone',
        );
    });
});
