<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Bot;

use ConduitUI\Mattermost\WebSocket\Events\Event;
use ConduitUI\Mattermost\WebSocket\Events\GenericEvent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

/**
 * Queueable wrapper around a {@see Handler} invocation.
 *
 * The router emits one of these whenever a handler implements
 * {@see ShouldQueue}. The job carries the handler's FQCN plus the raw
 * event payload (data + broadcast + seq + name) so the worker can
 * reconstruct the typed event and re-resolve the handler from the
 * container.
 */
class HandleEventJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var class-string<Event> */
    public string $eventClass;

    /** @var array<string, mixed> */
    public array $eventData;

    /** @var array<string, mixed> */
    public array $eventBroadcast;

    public int $eventSeq;

    public string $eventName;

    public function __construct(/** @var class-string<Handler> */
        public string $handlerClass, Event $event)
    {
        $this->eventClass = $event::class;
        $this->eventData = $event->data;
        $this->eventBroadcast = $event->broadcast;
        $this->eventSeq = $event->seq;
        $this->eventName = $event->name();

        $queue = config('mattermost.bot.queue');

        if (is_string($queue) && $queue !== '') {
            $this->onQueue($queue);
        }

        $connection = config('mattermost.bot.queue_connection');

        if (is_string($connection) && $connection !== '') {
            $this->onConnection($connection);
        }
    }

    public function handle(Container $container): void
    {
        $event = $this->reconstructEvent();
        $handler = $container->make($this->handlerClass);

        if (! $handler instanceof Handler) {
            return;
        }

        $handler->handle($event);
    }

    private function reconstructEvent(): Event
    {
        $class = $this->eventClass;

        if ($class === GenericEvent::class) {
            return new GenericEvent(
                $this->eventName,
                $this->eventData,
                $this->eventBroadcast,
                $this->eventSeq,
            );
        }

        /** @var Event $event */
        $event = new $class($this->eventData, $this->eventBroadcast, $this->eventSeq);

        return $event;
    }
}
