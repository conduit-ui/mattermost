<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Reactions\DeleteReaction;
use ConduitUI\Mattermost\Client\Requests\Reactions\GetBulkReactions;
use ConduitUI\Mattermost\Client\Requests\Reactions\GetReactions;
use ConduitUI\Mattermost\Client\Requests\Reactions\SaveReaction;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the getBulkReactions method in the Reactions resource', function (): void {
    Saloon::fake([
        GetBulkReactions::class => MockResponse::fixture('reactions.getBulkReactions'),
    ]);

    $response = $this->mattermost->reactions()->getBulkReactions(

    );

    Saloon::assertSent(GetBulkReactions::class);

    expect($response->status())->toBe(200);
});

it('calls the getReactions method in the Reactions resource', function (): void {
    Saloon::fake([
        GetReactions::class => MockResponse::fixture('reactions.getReactions'),
    ]);

    $response = $this->mattermost->reactions()->getReactions(
        postId: 'test string'
    );

    Saloon::assertSent(GetReactions::class);

    expect($response->status())->toBe(200);
});

it('calls the saveReaction method in the Reactions resource', function (): void {
    Saloon::fake([
        SaveReaction::class => MockResponse::fixture('reactions.saveReaction'),
    ]);

    $response = $this->mattermost->reactions()->saveReaction(

    );

    Saloon::assertSent(SaveReaction::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteReaction method in the Reactions resource', function (): void {
    Saloon::fake([
        DeleteReaction::class => MockResponse::fixture('reactions.deleteReaction'),
    ]);

    $response = $this->mattermost->reactions()->deleteReaction(
        userId: 'test string',
        postId: 'test string',
        emojiName: 'test string'
    );

    Saloon::assertSent(DeleteReaction::class);

    expect($response->status())->toBe(200);
});
