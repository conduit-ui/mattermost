<?php

declare(strict_types=1);

namespace ConduitUI\Mattermost\Client;

use Dotenv\Dotenv;
use Orchestra\Testbench\TestCase as Orchestra;
use Saloon\Laravel\SaloonServiceProvider;
use Spatie\LaravelData\LaravelDataServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            SaloonServiceProvider::class,
            LaravelDataServiceProvider::class,
            MattermostServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app): void
    {
        // Load .env.test into the environment.
        if (file_exists(dirname(__DIR__).'/.env')) {
            (Dotenv::createImmutable(dirname(__DIR__), '.env'))->load();
        }

        // todo: inject neccesary auth config
    }
}
