<?php

namespace LaraComponents\GraphQL\Test;

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

        $this->processor = $this->app->make(\Youshido\GraphQL\Execution\Processor::class);
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('graphql.schema', Schema::class);
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
