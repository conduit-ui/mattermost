<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Notifications\MattermostMessage;

describe('MattermostMessage', function (): void {
    it('builds a payload fluently', function (): void {
        $message = MattermostMessage::create('hello')
            ->channel('chan-1')
            ->rootId('post-root')
            ->connection('staging')
            ->fileIds(['f1', 'f2'])
            ->props(['from_webhook' => 'true']);

        expect($message->text)->toBe('hello');
        expect($message->channelId)->toBe('chan-1');
        expect($message->rootId)->toBe('post-root');
        expect($message->connection)->toBe('staging');
        expect($message->fileIds)->toBe(['f1', 'f2']);
        expect($message->props)->toBe(['from_webhook' => 'true']);
    });

    it('attaches Slack-style attachments via props', function (): void {
        $message = MattermostMessage::create('build green')
            ->attachments([
                ['text' => 'all checks passed', 'color' => '#36a64f'],
            ]);

        expect($message->props)->toHaveKey('attachments');
        expect($message->props['attachments'])->toBe([
            ['text' => 'all checks passed', 'color' => '#36a64f'],
        ]);
    });

    it('text() sets the message text', function (): void {
        $message = MattermostMessage::create()->text('updated');

        expect($message->text)->toBe('updated');
    });
});
