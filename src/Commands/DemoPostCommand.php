<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Commands;

use ConduitUI\Mattermost\Facades\Mattermost;
use Illuminate\Console\Command;

class DemoPostCommand extends Command
{
    /** @var string */
    protected $signature = 'mattermost:demo-post
        {channel=town-square : The channel name to post to}
        {text=Hello from Laravel! : The message text to post}
        {--team= : The team name (defaults to mattermost.connections.*.team config)}';

    /** @var string */
    protected $description = 'Post a message to a Mattermost channel via the Saloon API client';

    public function handle(): int
    {
        /** @var string $channelName */
        $channelName = $this->argument('channel');

        /** @var string $text */
        $text = $this->argument('text');

        $teamName = $this->resolveTeamName();

        if ($teamName === null) {
            $this->error('No team name configured. Set MATTERMOST_TEAM in your .env or pass --team=<name>.');

            return self::FAILURE;
        }

        $this->info("Resolving channel [{$channelName}] on team [{$teamName}]...");

        $teamResponse = Mattermost::teams()->getTeamByName($teamName);

        /** @var array{id: string} $teamData */
        $teamData = $teamResponse->json();
        $teamId = $teamData['id'];

        $channelResponse = Mattermost::channels()->getChannelByName($teamId, $channelName);

        /** @var array{id: string} $channelData */
        $channelData = $channelResponse->json();
        $channelId = $channelData['id'];

        Mattermost::posts()->createPost(channelId: $channelId, message: $text);

        $this->info("Posted to [{$channelName}]: {$text}");

        return self::SUCCESS;
    }

    private function resolveTeamName(): ?string
    {
        /** @var string|null $option */
        $option = $this->option('team');

        if ($option !== null && $option !== '') {
            return $option;
        }

        /** @var string|null $connectionName */
        $connectionName = config('mattermost.default', 'default');

        /** @var string|null $team */
        $team = config("mattermost.connections.{$connectionName}.team");

        return $team !== null && $team !== '' ? $team : null;
    }
}
