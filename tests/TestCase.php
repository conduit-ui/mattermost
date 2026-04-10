<?php

namespace ConduitUI\Mattermost\Tests;

use ConduitUI\Mattermost\MattermostServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            MattermostServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('mattermost.connections.default', [
            'url' => 'http://localhost:8065',
            'token' => 'test-token',
            'bot_user_id' => 'bot-user-id',
        ]);
    }
}
