<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Messages;

use Closure;
use DateTimeInterface;

/**
 * Builder for a Mattermost message attachment (Slack-compatible).
 *
 * @see https://docs.mattermost.com/developer/message-attachments.html
 */
class Attachment
{
    private ?string $fallback = null;

    private ?string $color = null;

    private ?string $pretext = null;

    private ?string $authorName = null;

    private ?string $authorLink = null;

    private ?string $authorIcon = null;

    private ?string $title = null;

    private ?string $titleLink = null;

    private ?string $text = null;

    /** @var list<array{title: string, value: string, short: bool}> */
    private array $fields = [];

    private ?string $imageUrl = null;

    private ?string $thumbUrl = null;

    private ?string $footer = null;

    private ?string $footerIcon = null;

    private ?int $timestamp = null;

    /** @var list<Action> */
    private array $actions = [];

    public function fallback(string $fallback): self
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function color(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function pretext(string $pretext): self
    {
        $this->pretext = $pretext;

        return $this;
    }

    public function author(string $name, ?string $link = null, ?string $icon = null): self
    {
        $this->authorName = $name;
        $this->authorLink = $link;
        $this->authorIcon = $icon;

        return $this;
    }

    public function title(string $title, ?string $link = null): self
    {
        $this->title = $title;
        $this->titleLink = $link;

        return $this;
    }

    public function text(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function field(string $title, string $value, bool $short = false): self
    {
        $this->fields[] = [
            'title' => $title,
            'value' => $value,
            'short' => $short,
        ];

        return $this;
    }

    /**
     * @param  list<array{title: string, value: string, short?: bool}>  $fields
     */
    public function fields(array $fields): self
    {
        foreach ($fields as $field) {
            $this->field(
                $field['title'],
                $field['value'],
                $field['short'] ?? false,
            );
        }

        return $this;
    }

    public function image(string $url): self
    {
        $this->imageUrl = $url;

        return $this;
    }

    public function thumb(string $url): self
    {
        $this->thumbUrl = $url;

        return $this;
    }

    public function footer(string $footer, ?string $icon = null): self
    {
        $this->footer = $footer;
        $this->footerIcon = $icon;

        return $this;
    }

    public function timestamp(int|DateTimeInterface $ts): self
    {
        $this->timestamp = $ts instanceof DateTimeInterface ? $ts->getTimestamp() : $ts;

        return $this;
    }

    /**
     * Add an interactive action (button or select menu) via a builder closure.
     *
     * @param  Closure(Action): void|Closure(Action): Action  $configure
     */
    public function action(Closure $configure): self
    {
        $action = new Action;
        $configure($action);
        $this->actions[] = $action;

        return $this;
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public function button(string $name, string $url, array $context = []): self
    {
        return $this->action(static fn (Action $a): Action => $a->button($name, $url, $context));
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if ($this->fallback !== null) {
            $payload['fallback'] = $this->fallback;
        }

        if ($this->color !== null) {
            $payload['color'] = $this->color;
        }

        if ($this->pretext !== null) {
            $payload['pretext'] = $this->pretext;
        }

        if ($this->authorName !== null) {
            $payload['author_name'] = $this->authorName;
        }

        if ($this->authorLink !== null) {
            $payload['author_link'] = $this->authorLink;
        }

        if ($this->authorIcon !== null) {
            $payload['author_icon'] = $this->authorIcon;
        }

        if ($this->title !== null) {
            $payload['title'] = $this->title;
        }

        if ($this->titleLink !== null) {
            $payload['title_link'] = $this->titleLink;
        }

        if ($this->text !== null) {
            $payload['text'] = $this->text;
        }

        if ($this->fields !== []) {
            $payload['fields'] = $this->fields;
        }

        if ($this->imageUrl !== null) {
            $payload['image_url'] = $this->imageUrl;
        }

        if ($this->thumbUrl !== null) {
            $payload['thumb_url'] = $this->thumbUrl;
        }

        if ($this->footer !== null) {
            $payload['footer'] = $this->footer;
        }

        if ($this->footerIcon !== null) {
            $payload['footer_icon'] = $this->footerIcon;
        }

        if ($this->timestamp !== null) {
            $payload['ts'] = $this->timestamp;
        }

        if ($this->actions !== []) {
            $payload['actions'] = array_map(
                static fn (Action $action): array => $action->toArray(),
                $this->actions,
            );
        }

        return $payload;
    }
}
