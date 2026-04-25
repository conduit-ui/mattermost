<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Requests\Posts\PatchPost;
use ConduitUI\Mattermost\Client\Requests\Posts\UpdatePost;
use ConduitUI\Mattermost\Facades\Mattermost;

describe('Posts integration', function (): void {
    it('creates and fetches a post via the Saloon client', function (): void {
        $channelId = $this->credentials()->channelId;

        $created = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: createPost @ '.uniqid(),
        );

        expect($created->status())->toBe(201);

        $postId = $created->json('id');
        expect($postId)->toBeString();

        $fetched = Mattermost::posts()->getPost($postId);

        expect($fetched->status())->toBe(200);
        expect($fetched->json('id'))->toBe($postId);
        expect($fetched->json('message'))->toBe($created->json('message'));
    });

    it('updates a post body via UpdatePost (verifies HasBody fix)', function (): void {
        $channelId = $this->credentials()->channelId;

        $created = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: pre-update',
        );
        $postId = $created->json('id');

        // UpdatePost (PUT /api/v4/posts/{id}) is a HasBody request — the
        // resource method takes only the id, so we apply the body via the
        // HasBody fluent surface, mirroring how MattermostStreamingReply
        // does it. Without the HasBody contract the body would be dropped
        // and the message would never change.
        $request = new UpdatePost($postId);
        $request->body()->merge([
            'id' => $postId,
            'message' => 'integration: post-update',
        ]);

        $updated = Mattermost::send($request);

        expect($updated->status())->toBe(200);

        $fetched = Mattermost::posts()->getPost($postId);
        expect($fetched->json('message'))->toBe('integration: post-update');
    });

    it('patches a post body via PatchPost', function (): void {
        $channelId = $this->credentials()->channelId;

        $created = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: pre-patch',
        );
        $postId = $created->json('id');

        $request = new PatchPost($postId);
        $request->body()->merge(['message' => 'integration: post-patch']);

        $patched = Mattermost::send($request);

        expect($patched->status())->toBe(200);

        $fetched = Mattermost::posts()->getPost($postId);
        expect($fetched->json('message'))->toBe('integration: post-patch');
    });

    it('creates a thread reply with root_id', function (): void {
        $channelId = $this->credentials()->channelId;

        $root = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: thread root',
        );
        $rootId = $root->json('id');

        $reply = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: reply',
            rootId: $rootId,
        );

        expect($reply->status())->toBe(201);
        expect($reply->json('root_id'))->toBe($rootId);
    });

    it('deletes a post and the next fetch reflects the soft delete', function (): void {
        $channelId = $this->credentials()->channelId;

        $created = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: to-delete',
        );
        $postId = $created->json('id');

        $deleted = Mattermost::posts()->deletePost($postId);

        expect($deleted->status())->toBe(200);

        // After delete, the post is soft-deleted: getPost returns 404
        // (the bot is not a system admin, so it can't see deleted posts).
        $fetched = Mattermost::posts()->getPost($postId);
        expect($fetched->status())->toBe(404);
    });
});
