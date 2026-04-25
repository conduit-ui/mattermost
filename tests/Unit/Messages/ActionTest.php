<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Messages\Action;

describe('Action builder', function (): void {
    it('builds a button action', function (): void {
        $payload = (new Action)
            ->button('Approve', 'https://example.test/cb', ['post_id' => 'p1'])
            ->toArray();

        expect($payload)->toBe([
            'name' => 'Approve',
            'type' => 'button',
            'integration' => [
                'url' => 'https://example.test/cb',
                'context' => ['post_id' => 'p1'],
            ],
        ]);
    });

    it('builds a select action with assoc options', function (): void {
        $payload = (new Action)
            ->select('Pick', 'https://example.test/cb', [
                ['text' => 'One', 'value' => '1'],
                ['text' => 'Two', 'value' => '2'],
            ])
            ->toArray();

        expect($payload['type'])->toBe('select');
        expect($payload['options'])->toBe([
            ['text' => 'One', 'value' => '1'],
            ['text' => 'Two', 'value' => '2'],
        ]);
    });

    it('builds a select action with positional option tuples', function (): void {
        $payload = (new Action)
            ->select('Pick', 'https://example.test/cb', [
                ['One', '1'],
                ['Two', '2'],
            ])
            ->toArray();

        expect($payload['options'])->toBe([
            ['text' => 'One', 'value' => '1'],
            ['text' => 'Two', 'value' => '2'],
        ]);
    });

    it('uses a built-in data source', function (): void {
        $payload = (new Action)
            ->select('Pick a user', 'https://example.test/cb', [])
            ->dataSource('users')
            ->toArray();

        expect($payload['data_source'])->toBe('users');
    });

    it('captures id and style', function (): void {
        $payload = (new Action)
            ->id('act-1')
            ->style('danger')
            ->button('Delete', 'https://example.test/del')
            ->toArray();

        expect($payload)->toMatchArray([
            'id' => 'act-1',
            'style' => 'danger',
            'name' => 'Delete',
            'type' => 'button',
        ]);
    });

    it('serializes empty when nothing is set', function (): void {
        expect((new Action)->toArray())->toBe([]);
    });
});
