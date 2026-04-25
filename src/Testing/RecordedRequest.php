<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Testing;

use Saloon\Http\PendingRequest;
use Saloon\Http\Request;

/**
 * Value object describing a request that was sent through a faked Mattermost
 * connection. Exposes the request instance and a decoded payload so consumer
 * tests can write expressive assertions.
 */
class RecordedRequest
{
    /**
     * @param  array<string, mixed>  $payload
     * @param  array<string, mixed>  $query
     */
    public function __construct(
        public readonly Request $request,
        public readonly string $connection,
        public readonly string $url,
        public readonly string $method,
        public readonly array $payload,
        public readonly array $query,
    ) {}

    public static function fromPendingRequest(PendingRequest $pendingRequest, string $connection): self
    {
        $body = $pendingRequest->body();
        $payload = [];

        if ($body !== null) {
            $rawBody = $body->all();

            if (is_array($rawBody)) {
                /** @var array<string, mixed> $payload */
                $payload = $rawBody;
            } elseif (is_string($rawBody) && $rawBody !== '') {
                $decoded = json_decode($rawBody, true);

                if (is_array($decoded)) {
                    /** @var array<string, mixed> $payload */
                    $payload = $decoded;
                }
            }
        }

        $query = $pendingRequest->query()->all();

        return new self(
            request: $pendingRequest->getRequest(),
            connection: $connection,
            url: $pendingRequest->getUrl(),
            method: $pendingRequest->getMethod()->value,
            payload: $payload,
            /** @var array<string, mixed> $query */
            query: $query,
        );
    }

    /**
     * Convenience accessor — returns the payload value at the given key.
     */
    public function get(string $key, mixed $default = null): mixed
    {
        return $this->payload[$key] ?? $default;
    }

    public function isFor(string $requestClass): bool
    {
        return $this->request instanceof $requestClass;
    }
}
