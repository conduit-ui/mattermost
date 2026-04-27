<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Commands;

use ConduitUI\Mattermost\Facades\Mattermost;
use Illuminate\Console\Command;
use Throwable;

class HealthCommand extends Command
{
    /** @var string */
    protected $signature = 'mattermost:health
        {--connection= : The named connection to check (defaults to mattermost.default)}';

    /** @var string */
    protected $description = 'Check Mattermost connectivity — auth, ping, version, latency';

    public function handle(): int
    {
        $connection = $this->connectionName();
        $this->info("Checking Mattermost connection [{$connection}]...");
        $this->newLine();

        $authOk = false;
        $authUser = '—';
        $authLatency = '—';

        $pingOk = false;
        $pingStatus = '—';
        $serverVersion = '—';
        $pingLatency = '—';

        try {
            $start = microtime(true);
            $meResponse = Mattermost::connection($connection)->users()->getUser('me');
            $authLatency = $this->formatLatency($start);

            if ($meResponse->successful()) {
                $authOk = true;
                /** @var array{username?: string} $meData */
                $meData = $meResponse->json();
                $authUser = $meData['username'] ?? '—';
            }
        } catch (Throwable $e) {
            $authLatency = 'error';
            $this->components->error("Auth check failed: {$e->getMessage()}");
        }

        try {
            $start = microtime(true);
            $pingResponse = Mattermost::connection($connection)->system()->getPing(getServerStatus: true);
            $pingLatency = $this->formatLatency($start);

            /** @var array{status?: string, version?: string} $pingData */
            $pingData = $pingResponse->json();

            $pingStatus = $pingData['status'] ?? '—';
            $pingOk = $pingStatus === 'OK';
            $serverVersion = $pingData['version'] ?? '—';
        } catch (Throwable $e) {
            $pingLatency = 'error';
            $this->components->error("Ping check failed: {$e->getMessage()}");
        }

        $this->table(
            ['Check', 'Result', 'Detail'],
            [
                ['Auth (/users/me)', $authOk ? '✓ OK' : '✗ FAIL', "user={$authUser}  latency={$authLatency}"],
                ['Ping (/system/ping)', $pingOk ? '✓ OK' : '✗ FAIL', "status={$pingStatus}  latency={$pingLatency}"],
                ['Server Version', $serverVersion, ''],
            ],
        );

        return $authOk && $pingOk ? self::SUCCESS : self::FAILURE;
    }

    private function connectionName(): string
    {
        /** @var string|null $option */
        $option = $this->option('connection');

        if ($option !== null && $option !== '') {
            return $option;
        }

        /** @var string $default */
        $default = config('mattermost.default', 'default');

        return $default;
    }

    private function formatLatency(float $start): string
    {
        $ms = (microtime(true) - $start) * 1000;

        return round($ms).'ms';
    }
}
