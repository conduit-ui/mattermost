<?php

declare(strict_types=1);

use ConduitUI\Mattermost\SlashCommands\SlashCommandResponse;

describe('SlashCommandResponse', function (): void {
    it('defaults to ephemeral response type', function (): void {
        $response = SlashCommandResponse::make('Hello');

        expect($response->toArray())->toBe([
            'response_type' => 'ephemeral',
            'text' => 'Hello',
        ]);
    });

    it('supports in_channel response type', function (): void {
        $response = SlashCommandResponse::make('Deployed!')->inChannel();

        expect($response->toArray()['response_type'])->toBe('in_channel');
    });

    it('can switch back to ephemeral after in_channel', function (): void {
        $response = SlashCommandResponse::make('test')->inChannel()->ephemeral();

        expect($response->toArray()['response_type'])->toBe('ephemeral');
    });

    it('builds with fluent text setter', function (): void {
        $response = SlashCommandResponse::make()->text('hello world');

        expect($response->toArray()['text'])->toBe('hello world');
    });

    it('defaults text to empty string when not provided', function (): void {
        $response = SlashCommandResponse::make();

        expect($response->toArray()['text'])->toBe('');
    });

    it('includes attachments when added', function (): void {
        $response = SlashCommandResponse::make('Details below')
            ->attachment(['title' => 'Build Log', 'text' => 'All green']);

        $array = $response->toArray();

        expect($array)->toHaveKey('attachments')
            ->and($array['attachments'])->toHaveCount(1)
            ->and($array['attachments'][0]['title'])->toBe('Build Log');
    });

    it('omits attachments key when none are added', function (): void {
        $response = SlashCommandResponse::make('Simple');

        expect($response->toArray())->not->toHaveKey('attachments');
    });

    it('supports multiple attachments', function (): void {
        $response = SlashCommandResponse::make('Multi')
            ->attachment(['title' => 'One'])
            ->attachment(['title' => 'Two']);

        expect($response->toArray()['attachments'])->toHaveCount(2);
    });
});
