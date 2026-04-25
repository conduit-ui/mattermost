<?php

declare(strict_types=1);

use ConduitUI\Mattermost\WebSocket\Backoff;

describe('Backoff', function (): void {
    it('doubles each step until the cap', function (): void {
        $b = new Backoff(initial: 1, max: 60);

        expect([
            $b->next(),
            $b->next(),
            $b->next(),
            $b->next(),
            $b->next(),
            $b->next(),
            $b->next(),
        ])->toBe([1, 2, 4, 8, 16, 32, 60]);
    });

    it('stays at the cap on further calls', function (): void {
        $b = new Backoff(initial: 1, max: 8);

        $b->next(); // 1
        $b->next(); // 2
        $b->next(); // 4
        $b->next(); // 8

        expect($b->next())->toBe(8);
        expect($b->next())->toBe(8);
    });

    it('resets to initial', function (): void {
        $b = new Backoff(initial: 1, max: 60);
        $b->next();
        $b->next();
        $b->next();

        $b->reset();

        expect($b->next())->toBe(1);
    });
});
