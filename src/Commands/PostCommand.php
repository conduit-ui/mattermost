<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Commands;

use ConduitUI\Mattermost\Facades\Mattermost;
use Illuminate\Console\Command;
use Throwable;

class PostCommand extends Command
{
    /** @var string */
    protected $signature = 'mattermost:post
        {channel : Channel ID or channel name to post to}
        {message : The message text to post}
        {--connection= : The named connection (defaults to mattermost.default)}
        {--team= : Team name for channel-name resolution (defaults to config)}';

    /** @var string */
    protected $description = 'Post a message to a Mattermost channel';

    public function handle(): int
    {
        /** @var string $channel */
        $channel = $this->argument('channel');

        /** @var string $message */
        $message = $this->argument('message');

        $connection = $this->connectionName();

        try {
            $channelId = $this->resolveChannelId($channel, $connection);
        } catch (Throwable $e) {
            $this->components->error("Failed to resolve channel [{$channel}]: {$e->getMessage()}");

            return self::FAILURE;
        }

        try {
            Mattermost::connection($connection)->posts()->createPost(
                channelId: $channelId,
                message: $message,
            );
        } catch (Throwable $e) {
            $this->components->error("Failed to post message: {$e->getMessage()}");

            return self::FAILURE;
        }

        $this->info("Posted to [{$channel}]: {$message}");

        return self::SUCCESS;
    }

    /**
     * If the channel argument looks like a 26-char Mattermost ID, use it directly.
     * Otherwise, resolve it by name via the team.
     */
    private function resolveChannelId(string $channel, string $connection): string
    {
        if ($this->looksLikeId($channel)) {
            return $channel;
        }

        $teamName = $this->resolveTeamName($connection);

        if ($teamName === null) {
            throw new \RuntimeException(
                'Channel name given but no team configured. Set MATTERMOST_TEAM in .env or pass --team=<name>.',
            );
        }

        $this->info("Resolving channel [{$channel}] on team [{$teamName}]...");

        $teamResponse = Mattermost::connection($connection)->teams()->getTeamByName($teamName);

        /** @var array{id: string} $teamData */
        $teamData = $teamResponse->json();

        $channelResponse = Mattermost::connection($connection)->channels()->getChannelByName($teamData['id'], $channel);

        /** @var array{id: string} $channelData */
        $channelData = $channelResponse->json();

        return $channelData['id'];
    }

    private function looksLikeId(string $value): bool
    {
        return (bool) preg_match('/\A[a-z0-9]{26}\z/', $value);
    }

    private function resolveTeamName(string $connection): ?string
    {
        /** @var string|null $option */
        $option = $this->option('team');

        if ($option !== null && $option !== '') {
            return $option;
        }

        /** @var string|null $team */
        $team = config("mattermost.connections.{$connection}.team");

        return $team !== null && $team !== '' ? $team : null;
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
}
