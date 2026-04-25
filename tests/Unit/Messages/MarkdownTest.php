<?php

declare(strict_types=1);

use ConduitUI\Mattermost\Messages\Markdown;

describe('Markdown helpers', function (): void {
    it('formats bold', fn () => expect(Markdown::bold('x'))->toBe('**x**'));
    it('formats italic', fn () => expect(Markdown::italic('x'))->toBe('*x*'));
    it('formats strikethrough', fn () => expect(Markdown::strikethrough('x'))->toBe('~~x~~'));
    it('formats inline code', fn () => expect(Markdown::code('x'))->toBe('`x`'));

    it('formats a code block without language', function (): void {
        expect(Markdown::codeBlock('hello'))->toBe("```\nhello\n```");
    });

    it('formats a code block with language', function (): void {
        expect(Markdown::codeBlock('echo 1', 'php'))->toBe("```php\necho 1\n```");
    });

    it('formats a link', function (): void {
        expect(Markdown::link('site', 'https://example.test'))
            ->toBe('[site](https://example.test)');
    });

    it('formats an image', function (): void {
        expect(Markdown::image('alt', 'https://example.test/i.png'))
            ->toBe('![alt](https://example.test/i.png)');
    });

    it('formats a multi-line blockquote', function (): void {
        expect(Markdown::blockquote("a\nb"))->toBe("> a\n> b");
    });

    it('formats a table', function (): void {
        $table = Markdown::table(
            ['H1', 'H2'],
            [['a', 'b'], ['c', 'd']],
        );

        expect($table)->toBe(
            "| H1 | H2 |\n".
            "| --- | --- |\n".
            "| a | b |\n".
            '| c | d |'
        );
    });

    it('renders a mention with or without leading @', function (): void {
        expect(Markdown::mention('alice'))->toBe('@alice')
            ->and(Markdown::mention('@bob'))->toBe('@bob');
    });

    it('renders a channel reference with or without leading ~', function (): void {
        expect(Markdown::channel('town-square'))->toBe('~town-square')
            ->and(Markdown::channel('~off-topic'))->toBe('~off-topic');
    });

    it('renders an emoji with or without surrounding colons', function (): void {
        expect(Markdown::emoji('rocket'))->toBe(':rocket:')
            ->and(Markdown::emoji(':tada:'))->toBe(':tada:');
    });
});
