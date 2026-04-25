<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Messages\Attachment;
use ConduitUI\Mattermost\Messages\Message;

describe('Message builder', function (): void {
    it('builds an empty message', function (): void {
        expect(Message::make()->toArray())->toBe(['message' => '']);
    });

    it('captures text via make()', function (): void {
        expect(Message::make('hello')->toArray())
            ->toBe(['message' => 'hello']);
    });

    it('captures text via text()', function (): void {
        expect(Message::make()->text('hello')->toArray())
            ->toBe(['message' => 'hello']);
    });

    it('targets a channel via to()', function (): void {
        $payload = Message::to('town-square')->text('hi')->toArray();

        expect($payload)->toBe([
            'channel_id' => 'town-square',
            'message' => 'hi',
        ]);
    });

    it('appends text with default newline separator', function (): void {
        $payload = Message::make('first')->append('second')->toArray();

        expect($payload['message'])->toBe("first\nsecond");
    });

    it('appends text with custom separator', function (): void {
        $payload = Message::make('a')->append('b', ' | ')->toArray();

        expect($payload['message'])->toBe('a | b');
    });

    it('append on empty message starts the body', function (): void {
        $payload = Message::make()->append('only')->toArray();

        expect($payload['message'])->toBe('only');
    });

    it('threads via inThread()', function (): void {
        $payload = Message::make('reply')->inThread('root-post-id')->toArray();

        expect($payload)->toBe([
            'message' => 'reply',
            'root_id' => 'root-post-id',
        ]);
    });

    it('attaches a single file id', function (): void {
        $payload = Message::make('see attached')->files('file-1')->toArray();

        expect($payload['file_ids'])->toBe(['file-1']);
    });

    it('attaches multiple file ids and preserves order across calls', function (): void {
        $payload = Message::make('hi')
            ->files(['file-1', 'file-2'])
            ->files('file-3')
            ->toArray();

        expect($payload['file_ids'])->toBe(['file-1', 'file-2', 'file-3']);
    });

    it('builds attachments via closure', function (): void {
        $payload = Message::make('Deploy complete')
            ->attachment(fn (Attachment $a) => $a
                ->color('#36a64f')
                ->title('v2.1.0 shipped')
                ->field('Environment', 'production', short: true)
                ->field('Duration', '45s', short: true)
                ->footer('Deployed by Lexi')
            )
            ->toArray();

        expect($payload)->toBe([
            'message' => 'Deploy complete',
            'props' => [
                'attachments' => [[
                    'color' => '#36a64f',
                    'title' => 'v2.1.0 shipped',
                    'fields' => [
                        ['title' => 'Environment', 'value' => 'production', 'short' => true],
                        ['title' => 'Duration', 'value' => '45s', 'short' => true],
                    ],
                    'footer' => 'Deployed by Lexi',
                ]],
            ],
        ]);
    });

    it('accepts a pre-built Attachment instance', function (): void {
        $attachment = (new Attachment)->title('built outside');

        $payload = Message::make('hi')->attachment($attachment)->toArray();

        expect($payload['props']['attachments'])->toBe([['title' => 'built outside']]);
    });

    it('preserves attachment ordering across multiple calls', function (): void {
        $payload = Message::make()
            ->attachment(fn (Attachment $a) => $a->title('first'))
            ->attachment(fn (Attachment $a) => $a->title('second'))
            ->attachment(fn (Attachment $a) => $a->title('third'))
            ->toArray();

        expect(array_column($payload['props']['attachments'], 'title'))
            ->toBe(['first', 'second', 'third']);
    });

    it('omits props when no attachments or custom props are set', function (): void {
        $payload = Message::make('plain')->toArray();

        expect($payload)->not->toHaveKey('props');
    });

    it('serializes mixed text + attachment', function (): void {
        $payload = Message::make()
            ->text('Heads up')
            ->attachment(fn (Attachment $a) => $a->text('details'))
            ->toArray();

        expect($payload)->toBe([
            'message' => 'Heads up',
            'props' => [
                'attachments' => [['text' => 'details']],
            ],
        ]);
    });

    it('text() called twice keeps the last value', function (): void {
        $payload = Message::make('first')->text('second')->toArray();

        expect($payload['message'])->toBe('second');
    });

    it('supports custom props alongside attachments', function (): void {
        $payload = Message::make('hi')
            ->prop('from_webhook', 'true')
            ->attachment(fn (Attachment $a) => $a->title('t'))
            ->toArray();

        expect($payload['props'])->toBe([
            'from_webhook' => 'true',
            'attachments' => [['title' => 't']],
        ]);
    });

    it('rejects setting attachments via prop()', function (): void {
        Message::make()->prop('attachments', []);
    })->throws(InvalidArgumentException::class, 'attachment()');

    it('returns the same instance from chained calls', function (): void {
        $message = Message::make();

        expect($message->text('hi'))->toBe($message)
            ->and($message->channel('c'))->toBe($message)
            ->and($message->inThread('r'))->toBe($message);
    });
});
