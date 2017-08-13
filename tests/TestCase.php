<?php

namespace LaraComponents\GraphQL\Test;

use Youshido\GraphQL\Execution\Processor;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected $processor;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->processor = $this->app->make(Processor::class);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('graphql.schema', 'default');
        $app['config']->set('graphql.schemas.default', Schema::class);
        $app['config']->set('graphql.route', [
            'prefix' => 'graphql',
            'middleware' => [],
            'methods' => ['GET', 'POST'],
            'controller' => '\LaraComponents\GraphQL\GraphQLController@index',
        ]);
        $app['config']->set('graphql.response', [
            'headers' => [],
            'json_pretty' => false,
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            \LaraComponents\GraphQL\ServiceProvider::class,
        ];
    }
}
