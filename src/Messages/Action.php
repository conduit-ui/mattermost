<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Messages;

/**
 * Builder for an interactive message action (button or select menu).
 *
 * @see https://docs.mattermost.com/developer/interactive-messages.html
 */
class Action
{
    private ?string $id = null;

    private ?string $name = null;

    /** @var 'button'|'select'|null */
    private ?string $type = null;

    /** @var array<string, mixed>|null */
    private ?array $integration = null;

    /** @var 'default'|'primary'|'success'|'good'|'warning'|'danger'|null */
    private ?string $style = null;

    /** @var list<array{text: string, value: string}>|null */
    private ?array $options = null;

    private ?string $dataSource = null;

    /**
     * @param  array<string, mixed>  $context
     */
    public function button(string $name, string $url, array $context = []): self
    {
        $this->type = 'button';
        $this->name = $name;
        $this->integration = [
            'url' => $url,
            'context' => $context,
        ];

        return $this;
    }

    /**
     * @param  list<array{text: string, value: string}|array{0: string, 1: string}>  $options
     * @param  array<string, mixed>  $context
     */
    public function select(string $name, string $url, array $options, array $context = []): self
    {
        $this->type = 'select';
        $this->name = $name;
        $this->integration = [
            'url' => $url,
            'context' => $context,
        ];
        $this->options = array_map(
            static function (array $option): array {
                if (isset($option['text'], $option['value'])) {
                    return ['text' => (string) $option['text'], 'value' => (string) $option['value']];
                }

                return ['text' => (string) $option[0], 'value' => (string) $option[1]];
            },
            $options,
        );

        return $this;
    }

    /**
     * Use a built-in Mattermost data source (e.g. 'users', 'channels')
     * instead of a static options list.
     */
    public function dataSource(string $source): self
    {
        $this->dataSource = $source;

        return $this;
    }

    public function id(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function name(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function style(string $style): self
    {
        /** @var 'default'|'primary'|'success'|'good'|'warning'|'danger' $style */
        $this->style = $style;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $payload = [];

        if ($this->id !== null) {
            $payload['id'] = $this->id;
        }

        if ($this->name !== null) {
            $payload['name'] = $this->name;
        }

        if ($this->type !== null) {
            $payload['type'] = $this->type;
        }

        if ($this->style !== null) {
            $payload['style'] = $this->style;
        }

        if ($this->integration !== null) {
            $payload['integration'] = $this->integration;
        }

        if ($this->options !== null) {
            $payload['options'] = $this->options;
        }

        if ($this->dataSource !== null) {
            $payload['data_source'] = $this->dataSource;
        }

        return $payload;
    }
}
