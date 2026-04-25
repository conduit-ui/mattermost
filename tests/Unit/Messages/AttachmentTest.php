<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Messages\Action;
use ConduitUI\Mattermost\Messages\Attachment;

describe('Attachment builder', function (): void {
    it('serializes empty when nothing is set', function (): void {
        expect((new Attachment)->toArray())->toBe([]);
    });

    it('captures the full surface of attachment fields', function (): void {
        $payload = (new Attachment)
            ->fallback('plain-text fallback')
            ->color('#22c55e')
            ->pretext('above the box')
            ->author('Lexi', 'https://example.test/lexi', 'https://example.test/lexi.png')
            ->title('Build status', 'https://example.test/build/123')
            ->text('all green')
            ->field('Branch', 'main', short: true)
            ->field('Commit', 'abc123', short: true)
            ->image('https://example.test/img.png')
            ->thumb('https://example.test/thumb.png')
            ->footer('CI bot', 'https://example.test/footer.png')
            ->timestamp(1700000000)
            ->toArray();

        expect($payload)->toBe([
            'fallback' => 'plain-text fallback',
            'color' => '#22c55e',
            'pretext' => 'above the box',
            'author_name' => 'Lexi',
            'author_link' => 'https://example.test/lexi',
            'author_icon' => 'https://example.test/lexi.png',
            'title' => 'Build status',
            'title_link' => 'https://example.test/build/123',
            'text' => 'all green',
            'fields' => [
                ['title' => 'Branch', 'value' => 'main', 'short' => true],
                ['title' => 'Commit', 'value' => 'abc123', 'short' => true],
            ],
            'image_url' => 'https://example.test/img.png',
            'thumb_url' => 'https://example.test/thumb.png',
            'footer' => 'CI bot',
            'footer_icon' => 'https://example.test/footer.png',
            'ts' => 1700000000,
        ]);
    });

    it('defaults short=false for fields', function (): void {
        $payload = (new Attachment)->field('K', 'V')->toArray();

        expect($payload['fields'])->toBe([
            ['title' => 'K', 'value' => 'V', 'short' => false],
        ]);
    });

    it('accepts bulk fields and merges with single field calls in order', function (): void {
        $payload = (new Attachment)
            ->field('a', '1')
            ->fields([
                ['title' => 'b', 'value' => '2', 'short' => true],
                ['title' => 'c', 'value' => '3'],
            ])
            ->field('d', '4')
            ->toArray();

        expect(array_column($payload['fields'], 'title'))->toBe(['a', 'b', 'c', 'd']);
        expect($payload['fields'][2]['short'])->toBeFalse();
    });

    it('accepts a DateTimeInterface for timestamp', function (): void {
        $dt = new DateTimeImmutable('2024-01-15T10:30:00Z');

        $payload = (new Attachment)->timestamp($dt)->toArray();

        expect($payload['ts'])->toBe($dt->getTimestamp());
    });

    it('omits author_link and author_icon when only a name is provided', function (): void {
        $payload = (new Attachment)->author('Lexi')->toArray();

        expect($payload)->toBe(['author_name' => 'Lexi']);
    });

    it('omits title_link when only a title is provided', function (): void {
        $payload = (new Attachment)->title('only-title')->toArray();

        expect($payload)->toBe(['title' => 'only-title']);
    });

    it('builds button actions via the convenience helper', function (): void {
        $payload = (new Attachment)
            ->button('Approve', 'https://example.test/approve', ['id' => 42])
            ->toArray();

        expect($payload['actions'])->toBe([[
            'name' => 'Approve',
            'type' => 'button',
            'integration' => [
                'url' => 'https://example.test/approve',
                'context' => ['id' => 42],
            ],
        ]]);
    });

    it('builds actions via closure', function (): void {
        $payload = (new Attachment)
            ->action(fn (Action $a) => $a
                ->id('approve-btn')
                ->style('primary')
                ->button('Approve', 'https://example.test/approve')
            )
            ->toArray();

        expect($payload['actions'][0])->toMatchArray([
            'id' => 'approve-btn',
            'name' => 'Approve',
            'type' => 'button',
            'style' => 'primary',
        ]);
    });

    it('preserves action ordering', function (): void {
        $payload = (new Attachment)
            ->button('one', 'https://x.test/1')
            ->button('two', 'https://x.test/2')
            ->button('three', 'https://x.test/3')
            ->toArray();

        expect(array_column($payload['actions'], 'name'))->toBe(['one', 'two', 'three']);
    });

    it('returns the same instance from chained calls', function (): void {
        $a = new Attachment;

        expect($a->color('#fff'))->toBe($a)
            ->and($a->title('t'))->toBe($a)
            ->and($a->field('k', 'v'))->toBe($a);
    });
});
