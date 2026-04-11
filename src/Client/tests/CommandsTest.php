<?php

// Generated 2026-04-10 23:46:41

use ConduitUI\Mattermost\Client\Mattermost;
use ConduitUI\Mattermost\Client\Requests\Commands\CreateCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\DeleteCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\ExecuteCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\GetCommandById;
use ConduitUI\Mattermost\Client\Requests\Commands\ListAutocompleteCommands;
use ConduitUI\Mattermost\Client\Requests\Commands\ListCommands;
use ConduitUI\Mattermost\Client\Requests\Commands\MoveCommand;
use ConduitUI\Mattermost\Client\Requests\Commands\RegenCommandToken;
use ConduitUI\Mattermost\Client\Requests\Commands\UpdateCommand;
use Saloon\Http\Faking\MockResponse;
use Saloon\Laravel\Facades\Saloon;

beforeEach(function (): void {
    $this->mattermost = new Mattermost(
        bearerToken: 'replace'
    );
});

it('calls the listCommands method in the Commands resource', function (): void {
    Saloon::fake([
        ListCommands::class => MockResponse::fixture('commands.listCommands'),
    ]);

    $response = $this->mattermost->commands()->listCommands(
        teamId: 'test string',
        customOnly: true
    );

    Saloon::assertSent(ListCommands::class);

    expect($response->status())->toBe(200);
});

it('calls the createCommand method in the Commands resource', function (): void {
    Saloon::fake([
        CreateCommand::class => MockResponse::fixture('commands.createCommand'),
    ]);

    $response = $this->mattermost->commands()->createCommand(

    );

    Saloon::assertSent(CreateCommand::class);

    expect($response->status())->toBe(200);
});

it('calls the executeCommand method in the Commands resource', function (): void {
    Saloon::fake([
        ExecuteCommand::class => MockResponse::fixture('commands.executeCommand'),
    ]);

    $response = $this->mattermost->commands()->executeCommand(

    );

    Saloon::assertSent(ExecuteCommand::class);

    expect($response->status())->toBe(200);
});

it('calls the getCommandById method in the Commands resource', function (): void {
    Saloon::fake([
        GetCommandById::class => MockResponse::fixture('commands.getCommandById'),
    ]);

    $response = $this->mattermost->commands()->getCommandById(
        commandId: 'test string'
    );

    Saloon::assertSent(GetCommandById::class);

    expect($response->status())->toBe(200);
});

it('calls the updateCommand method in the Commands resource', function (): void {
    Saloon::fake([
        UpdateCommand::class => MockResponse::fixture('commands.updateCommand'),
    ]);

    $response = $this->mattermost->commands()->updateCommand(
        commandId: 'test string'
    );

    Saloon::assertSent(UpdateCommand::class);

    expect($response->status())->toBe(200);
});

it('calls the deleteCommand method in the Commands resource', function (): void {
    Saloon::fake([
        DeleteCommand::class => MockResponse::fixture('commands.deleteCommand'),
    ]);

    $response = $this->mattermost->commands()->deleteCommand(
        commandId: 'test string'
    );

    Saloon::assertSent(DeleteCommand::class);

    expect($response->status())->toBe(200);
});

it('calls the moveCommand method in the Commands resource', function (): void {
    Saloon::fake([
        MoveCommand::class => MockResponse::fixture('commands.moveCommand'),
    ]);

    $response = $this->mattermost->commands()->moveCommand(
        commandId: 'test string'
    );

    Saloon::assertSent(MoveCommand::class);

    expect($response->status())->toBe(200);
});

it('calls the regenCommandToken method in the Commands resource', function (): void {
    Saloon::fake([
        RegenCommandToken::class => MockResponse::fixture('commands.regenCommandToken'),
    ]);

    $response = $this->mattermost->commands()->regenCommandToken(
        commandId: 'test string'
    );

    Saloon::assertSent(RegenCommandToken::class);

    expect($response->status())->toBe(200);
});

it('calls the listAutocompleteCommands method in the Commands resource', function (): void {
    Saloon::fake([
        ListAutocompleteCommands::class => MockResponse::fixture('commands.listAutocompleteCommands'),
    ]);

    $response = $this->mattermost->commands()->listAutocompleteCommands(
        teamId: 'test string'
    );

    Saloon::assertSent(ListAutocompleteCommands::class);

    expect($response->status())->toBe(200);
});
