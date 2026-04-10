<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Requests\Preferences\GetPreferences;
use ConduitUI\Mattermost\Client\Requests\Preferences\UpdatePreferences;
use ConduitUI\Mattermost\Client\Requests\Preferences\DeletePreferences;
use ConduitUI\Mattermost\Client\Requests\Preferences\GetPreferencesByCategory;
use ConduitUI\Mattermost\Client\Requests\Preferences\GetPreferencesByCategoryByName;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;
use Spatie\LaravelData\DataCollection;

beforeEach(function () {
    $this->mattermost = new ConduitUI\Mattermost\Client\Mattermost(
		bearerToken: 'replace'
	);
});


it('calls the getPreferences method in the Preferences resource', function () {
    Saloon::fake([
        GetPreferences::class => MockResponse::fixture('preferences.getPreferences'),
    ]);

    $response = $this->mattermost->preferences()->getPreferences(
		userId: 'test string'
	);

    Saloon::assertSent(GetPreferences::class);

    expect($response->status())->toBe(200);
});


it('calls the updatePreferences method in the Preferences resource', function () {
    Saloon::fake([
        UpdatePreferences::class => MockResponse::fixture('preferences.updatePreferences'),
    ]);

    $response = $this->mattermost->preferences()->updatePreferences(
		userId: 'test string'
	);

    Saloon::assertSent(UpdatePreferences::class);

    expect($response->status())->toBe(200);
});


it('calls the deletePreferences method in the Preferences resource', function () {
    Saloon::fake([
        DeletePreferences::class => MockResponse::fixture('preferences.deletePreferences'),
    ]);

    $response = $this->mattermost->preferences()->deletePreferences(
		userId: 'test string'
	);

    Saloon::assertSent(DeletePreferences::class);

    expect($response->status())->toBe(200);
});


it('calls the getPreferencesByCategory method in the Preferences resource', function () {
    Saloon::fake([
        GetPreferencesByCategory::class => MockResponse::fixture('preferences.getPreferencesByCategory'),
    ]);

    $response = $this->mattermost->preferences()->getPreferencesByCategory(
		userId: 'test string',
		category: 'test string'
	);

    Saloon::assertSent(GetPreferencesByCategory::class);

    expect($response->status())->toBe(200);
});


it('calls the getPreferencesByCategoryByName method in the Preferences resource', function () {
    Saloon::fake([
        GetPreferencesByCategoryByName::class => MockResponse::fixture('preferences.getPreferencesByCategoryByName'),
    ]);

    $response = $this->mattermost->preferences()->getPreferencesByCategoryByName(
		userId: 'test string',
		category: 'test string',
		preferenceName: 'test string'
	);

    Saloon::assertSent(GetPreferencesByCategoryByName::class);

    expect($response->status())->toBe(200);
});
