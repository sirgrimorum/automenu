<?php

namespace Sirgrimorum\AutoMenu\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Sirgrimorum\AutoMenu\AutoMenuServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;

    protected function getPackageProviders($app): array
    {
        return [
            AutoMenuServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->app['db']->connection()->getSchemaBuilder()->dropIfExists('users');
        $this->app['db']->connection()->getSchemaBuilder()->create('users', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('app.key', 'base64:yvS68vVrTk8vS68vVrTk8vS68vVrTk8vS68vVrTk8vS=');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'mysql',
            'host'     => '127.0.0.1',
            'port'     => '3306',
            'database' => 'sirgrimorum_test',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix'   => '',
        ]);
    }
}
