<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Messages;

/**
 * Markdown helpers for Mattermost messages.
 *
 * Pure string helpers — no formatting state. Use as a static utility
 * when composing message text.
 *
 * @see https://docs.mattermost.com/messaging/formatting-text.html
 */
final class Markdown
{
    public static function bold(string $text): string
    {
        return '**'.$text.'**';
    }

    public static function italic(string $text): string
    {
        return '*'.$text.'*';
    }

    public static function strikethrough(string $text): string
    {
        return '~~'.$text.'~~';
    }

    public static function code(string $text): string
    {
        return '`'.$text.'`';
    }

    public static function codeBlock(string $text, ?string $language = null): string
    {
        return '```'.($language ?? '')."\n".$text."\n".'```';
    }

    public static function link(string $text, string $url): string
    {
        return '['.$text.']('.$url.')';
    }

    public static function image(string $alt, string $url): string
    {
        return '!['.$alt.']('.$url.')';
    }

    public static function blockquote(string $text): string
    {
        $lines = preg_split('/\r\n|\r|\n/', $text) ?: [];

        return implode("\n", array_map(static fn (string $line): string => '> '.$line, $lines));
    }

    /**
     * Render a markdown table.
     *
     * @param  list<string>  $headers
     * @param  list<list<string>>  $rows
     */
    public static function table(array $headers, array $rows): string
    {
        $headerLine = '| '.implode(' | ', $headers).' |';
        $separator = '| '.implode(' | ', array_fill(0, count($headers), '---')).' |';

        $body = array_map(
            static fn (array $row): string => '| '.implode(' | ', $row).' |',
            $rows,
        );

        return implode("\n", [$headerLine, $separator, ...$body]);
    }

    public static function mention(string $username): string
    {
        return '@'.ltrim($username, '@');
    }

    public static function channel(string $name): string
    {
        return '~'.ltrim($name, '~');
    }

    public static function emoji(string $name): string
    {
        return ':'.trim($name, ':').':';
    }
}
