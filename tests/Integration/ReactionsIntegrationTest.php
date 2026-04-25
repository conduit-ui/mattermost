<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use ConduitUI\Mattermost\Facades\Mattermost;

describe('Reactions integration', function (): void {
    it('reacts to a post, lists the reaction back, and removes it', function (): void {
        $channelId = $this->credentials()->channelId;
        $botUserId = $this->credentials()->botUserId;

        $created = Mattermost::posts()->createPost(
            channelId: $channelId,
            message: 'integration: reaction target',
        );
        $postId = $created->json('id');

        $request = new SaveReaction;
        $request->body()->merge([
            'user_id' => $botUserId,
            'post_id' => $postId,
            'emoji_name' => 'thumbsup',
        ]);

        $reaction = Mattermost::send($request);
        expect($reaction->status())->toBe(200);

        $list = Mattermost::reactions()->getReactions($postId);
        expect($list->status())->toBe(200);

        $emojis = array_map(
            static fn (array $r): string => (string) ($r['emoji_name'] ?? ''),
            $list->json(),
        );
        expect($emojis)->toContain('thumbsup');

        $removed = Mattermost::reactions()->deleteReaction($botUserId, $postId, 'thumbsup');
        expect($removed->status())->toBe(200);

        $listAfter = Mattermost::reactions()->getReactions($postId);
        // Mattermost returns the literal JSON `null` (not `[]`) when there
        // are zero reactions, which trips Saloon's typed Response::json()
        // (its $decodedJson property is array-typed). We bypass it by
        // decoding the raw body — assertion only cares that thumbsup is
        // gone, which is trivially true for a null body.
        $decoded = json_decode($listAfter->body(), true);
        $remaining = is_array($decoded) ? $decoded : [];
        $emojisAfter = array_map(
            static fn (array $r): string => (string) ($r['emoji_name'] ?? ''),
            $remaining,
        );
        expect($emojisAfter)->not->toContain('thumbsup');
    });
});
