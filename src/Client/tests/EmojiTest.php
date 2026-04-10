<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmojiList;
use ConduitUI\Mattermost\Client\Requests\Emoji\CreateEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\AutocompleteEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmojiByName;
use ConduitUI\Mattermost\Client\Requests\Emoji\SearchEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\DeleteEmoji;
use ConduitUI\Mattermost\Client\Requests\Emoji\GetEmojiImage;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getEmojiList method in the Emoji resource', function () {
    Saloon::fake([
        GetEmojiList::class => MockResponse::fixture('emoji.getEmojiList'),
    ]);

    $response = $this->mattermost->emoji()->getEmojiList(
		page: 123,
		sort: 'test string'
	);

    Saloon::assertSent(GetEmojiList::class);

    expect($response->status())->toBe(200);
});


it('calls the createEmoji method in the Emoji resource', function () {
    Saloon::fake([
        CreateEmoji::class => MockResponse::fixture('emoji.createEmoji'),
    ]);

    $response = $this->mattermost->emoji()->createEmoji(
		
	);

    Saloon::assertSent(CreateEmoji::class);

    expect($response->status())->toBe(200);
});


it('calls the autocompleteEmoji method in the Emoji resource', function () {
    Saloon::fake([
        AutocompleteEmoji::class => MockResponse::fixture('emoji.autocompleteEmoji'),
    ]);

    $response = $this->mattermost->emoji()->autocompleteEmoji(
		name: 'test string'
	);

    Saloon::assertSent(AutocompleteEmoji::class);

    expect($response->status())->toBe(200);
});


it('calls the getEmojiByName method in the Emoji resource', function () {
    Saloon::fake([
        GetEmojiByName::class => MockResponse::fixture('emoji.getEmojiByName'),
    ]);

    $response = $this->mattermost->emoji()->getEmojiByName(
		emojiName: 'test string'
	);

    Saloon::assertSent(GetEmojiByName::class);

    expect($response->status())->toBe(200);
});


it('calls the searchEmoji method in the Emoji resource', function () {
    Saloon::fake([
        SearchEmoji::class => MockResponse::fixture('emoji.searchEmoji'),
    ]);

    $response = $this->mattermost->emoji()->searchEmoji(
		
	);

    Saloon::assertSent(SearchEmoji::class);

    expect($response->status())->toBe(200);
});


it('calls the getEmoji method in the Emoji resource', function () {
    Saloon::fake([
        GetEmoji::class => MockResponse::fixture('emoji.getEmoji'),
    ]);

    $response = $this->mattermost->emoji()->getEmoji(
		emojiId: 'test string'
	);

    Saloon::assertSent(GetEmoji::class);

    expect($response->status())->toBe(200);
});


it('calls the deleteEmoji method in the Emoji resource', function () {
    Saloon::fake([
        DeleteEmoji::class => MockResponse::fixture('emoji.deleteEmoji'),
    ]);

    $response = $this->mattermost->emoji()->deleteEmoji(
		emojiId: 'test string'
	);

    Saloon::assertSent(DeleteEmoji::class);

    expect($response->status())->toBe(200);
});


it('calls the getEmojiImage method in the Emoji resource', function () {
    Saloon::fake([
        GetEmojiImage::class => MockResponse::fixture('emoji.getEmojiImage'),
    ]);

    $response = $this->mattermost->emoji()->getEmojiImage(
		emojiId: 'test string'
	);

    Saloon::assertSent(GetEmojiImage::class);

    expect($response->status())->toBe(200);
});
